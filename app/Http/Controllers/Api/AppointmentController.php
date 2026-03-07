<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\Complaint;
use App\Services\Notifier;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Complaint $complaint)
    {
        return AppointmentResource::collection($complaint->appointments()->latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request, Complaint $complaint)
    {
        $validated = $request->validated();

        $appointment = $complaint->appointments()->create($validated);

        Notifier::send(
            $complaint->user_id,
            'appointment_scheduled',
            'Your complaint appointment has been scheduled.',
            [
                'appointment_id' => $appointment->id,
                'complaint_id' => $complaint->id,
                'scheduled_at' => $appointment->scheduled_at,
                'status' => $appointment->status
            ]
        );

        return AppointmentResource::make($appointment)
            ->additional(['message' => 'Appointment created successfully'])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Complaint $complaint, Appointment $appointment)
    {
        if ($appointment->reference_id !== $complaint->id) {
            abort(404);
        }

        return AppointmentResource::make($appointment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Complaint $complaint, Appointment $appointment)
    {
        if ($appointment->reference_id !== $complaint->id) {
            abort(404);
        }

        $validated = $request->validated();

        $appointment->update($validated);

        Notifier::send(
            $complaint->user_id,
            'appointment_updated',
            'Your complaint appointment has been updated.',
            [
                'appointment_id' => $appointment->id,
                'complaint_id' => $complaint->id,
                'scheduled_at' => $appointment->scheduled_at,
                'status' => $appointment->status
            ]
        );

        return AppointmentResource::make($appointment)
            ->additional(['message' => 'Appointment updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // Check appointment availability
    public function availability(Request $request)
    {
        $request->validate([
            'start' => ['required','date'],
            'end' => ['required','date','after_or_equal:start']
        ]);

        $start = Carbon::parse($request->start);
        $end = Carbon::parse($request->end);

        $appointments = Appointment::whereBetween('scheduled_at', [$start, $end])
            ->get()
            ->groupBy(fn($a) => $a->scheduled_at->toDateString());

        $days = [];

        foreach (CarbonPeriod::create($start, $end) as $date) {

            $dateString = $date->toDateString();

            $taken = ($appointments[$dateString] ?? collect())
                ->map(fn($a) => $a->scheduled_at->format('H:00'))
                ->toArray();

            $slots = [];

            for ($hour = 7; $hour < 17; $hour++) {

                $time = sprintf('%02d:00', $hour);

                $available = !in_array($time, $taken);

                $slots[] = [
                    'time' => $time,
                    'available' => $available
                ];
            }

            $days[] = [
                'date' => $dateString,
                'is_full' => count($taken) >= 10,
                'slots' => $slots
            ];
        }

        return response()->json([
            'days' => $days
        ]);
    }
}
