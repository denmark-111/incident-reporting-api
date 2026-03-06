<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\Complaint;
use App\Services\Notifier;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Complaint $complaint)
    {
        return response()->json(
            $complaint->appointments()->latest()->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Complaint $complaint, Appointment $appointment)
    {
        if ($appointment->reference_id !== $complaint->id) {
            abort(404);
        }

        return response()->json($appointment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Complaint $complaint, Appointment $appointment)
    {
        if ($appointment->reference_id !== $complaint->id) {
            abort(404);
        }

        $data = $request->validated();

        $appointment->update($data);

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

        return response()->json([
            'message' => 'Appointment updated successfully',
            'data' => $appointment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
