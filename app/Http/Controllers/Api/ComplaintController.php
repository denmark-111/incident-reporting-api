<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComplaintRequest;
use App\Http\Requests\UpdateComplaintRequest;
use App\Http\Resources\ComplaintResource;
use App\Models\Appointment;
use App\Models\Complaint;
use App\Models\CustomField;
use App\Models\CustomFieldValue;
use App\Models\User;
use App\Services\Notifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ComplaintController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Complaint::class);

        $request->validate([
            'status'        => ['sometimes', 'string'],
            'severity'      => ['sometimes', 'string'],
            'type'          => ['sometimes', 'string'],
            'start_date'    => ['sometimes', 'date'],
            'end_date'      => ['sometimes', 'date', 'after_or_equal:start_date'],
            'per_page'      => ['sometimes', 'integer', 'min:1', 'max:100'],
        ]);

        $user = auth()->user();

        $query = $user->hasSubsystemAdminAccess()
            ? Complaint::with('witnesses', 'customFieldValues.customField', 'appointments')
            : $user->complaints()->with('witnesses', 'customFieldValues.customField', 'appointments');

        // Filter by status
        $query->when($request->status, function ($q) use ($request) {
            $q->where('status', $request->status);
        });

        // Filter by severity
        $query->when($request->severity, function ($q) use ($request) {
            $q->where('severity', $request->severity);
        });

        // Filter by type
        $query->when($request->type, function ($q) use ($request) {
            $q->where('type', $request->type);
        });

        // Filter by start date
        $query->when($request->start_date, function ($q) use ($request) {
            $q->whereDate('incident_date', '>=', $request->start_date);
        });

        // Filter by end date
        $query->when($request->end_date, function ($q) use ($request) {
            $q->whereDate('incident_date', '<=', $request->end_date);
        });

        $perPage = $request->per_page ?? 10;

        $paginated = $query->latest()->paginate($perPage)
            ->appends($request->only([
                'status', 'severity', 'type', 'start_date', 'end_date', 'per_page'
            ]));
        
        return ComplaintResource::collection($paginated);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComplaintRequest $request)
    {
        $this->authorize('create', Complaint::class);
        
        $data = $request->validated();

        // Extract and remove witnesses data from the main data array, will be handled separately
        $witnesses = $data['witnesses'] ?? [];
        unset($data['witnesses']); //

        // Handle file upload if present
        if ($request->hasFile('evidence')) {
            $path = $request->file('evidence')->store('evidence', 'public');
            $data['evidence_path'] = $path;
        }

        $complaint = $request->user()->complaints()->create([
            ...$data,
            'status' => 'pending'
        ]);

        if (!empty($witnesses)) {
            $complaint->witnesses()->createMany($witnesses);
        }

        // Save custom field values
        if (!empty($data['custom_fields'])) {

            $customFields = CustomField::where('field_for', 'complaint')
                ->where('is_active', true)
                ->get()
                ->keyBy('field_name');

            foreach ($data['custom_fields'] as $fieldName => $value) {

                if (!isset($customFields[$fieldName])) {
                    continue; // ignore invalid field
                }

                CustomFieldValue::create([
                    'custom_field_id' => $customFields[$fieldName]->id,
                    'complaint_id' => $complaint->id,
                    'value' => is_array($value)
                                ? json_encode($value)
                                : $value,
                ]);
            }
        }

        // Notify all users with admin-level access to the subsystem
        $admins = User::subsystemAdmins()->pluck('id')->toArray();

        Notifier::send(
            $admins,
            'complaint_created',
            'A new complaint has been submitted.',
            [
                'complaint_id' => $complaint->id,
                'submitted_by' => $complaint->user->name,
                'description' => $complaint->description,
            ]
        );
        
        return ComplaintResource::make($complaint->load('witnesses', 'customFieldValues.customField', 'appointments'))
            ->additional(['message' => 'Complaint created successfully'])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Complaint $complaint)
    {
        $this->authorize('view', $complaint);

        return ComplaintResource::make($complaint->load('witnesses', 'customFieldValues.customField', 'appointments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComplaintRequest $request, Complaint $complaint)
    {
        $this->authorize('update', $complaint);
        
        $data = $request->validated();

        // Extract and remove witnesses data from the main data array, will be handled separately
        $witnesses = $data['witnesses'] ?? null;
        unset($data['witnesses']);

        // Handle file upload if present
        if ($request->hasFile('evidence')) {
            // Delete old file if exists
            if ($complaint->evidence_path && Storage::disk('public')->exists($complaint->evidence_path)) {
                Storage::disk('public')->delete($complaint->evidence_path);
            }

            $path = $request->file('evidence')->store('evidence', 'public');
            $data['evidence_path'] = $path;
        }

        $complaint->update($data);

        // Update witnesses: delete all if present in request (even empty) and add new if provided
        if ($request->has('witnesses')) {
            $complaint->witnesses()->delete();
            if (!empty($witnesses)) {
                $complaint->witnesses()->createMany($witnesses);
            }
        }

        // Update custom field values
        if ($request->has('custom_fields')) {
            
            $customFields = CustomField::where('field_for', 'complaint')
                ->where('is_active', true)
                ->get()
                ->keyBy('field_name');

            foreach ($request->input('custom_fields', []) as $fieldName => $value) {

                if (!isset($customFields[$fieldName])) {
                    continue;
                }

                $field = $customFields[$fieldName];

                CustomFieldValue::updateOrCreate(
                    [
                        'complaint_id' => $complaint->id,
                        'custom_field_id' => $field->id,
                    ],
                    [
                        'value' => is_array($value)
                            ? json_encode($value)
                            : $value,
                    ]
                );
            }
        }

        // If status is updated to in-progress, create an appointment
        if ($complaint->wasChanged('status') && $complaint->status === 'in-progress') {

            $date = now()->addDays(3)->startOfDay(); // Start searching from 3 days later

            $appointmentCreated = false;

            while (! $appointmentCreated) {

                // Skip weekends
                if ($date->isWeekend()) {
                    $date->addDay()->startOfDay();
                    continue;
                }

                // Operating hours 7AM - 4PM (last slot = 4PM–5PM)
                for ($hour = 7; $hour < 17; $hour++) {

                    $scheduledAt = $date->copy()->setTime($hour, 0, 0);

                    $start = $scheduledAt->copy();
                    $end   = $scheduledAt->copy()->endOfHour();

                    // checck if slot is already taken by another appointment
                    $exists = Appointment::whereBetween('scheduled_at', [$start, $end])->exists();

                    if (! $exists) {
                        $appointment = $complaint->appointments()->create([
                            'title'       => 'Summon for Complaint #' . $complaint->id,
                            'description' => 'Appointment for mediating complaint #' . $complaint->id,
                            'scheduled_at' => $start,
                        ]);

                        Notifier::send(
                            $complaint->user_id,
                            'appointment_scheduled',
                            'An appointment has been scheduled for your complaint.',
                            [
                                'appointment_id' => $appointment->id,
                                'complaint_id' => $complaint->id,
                                'scheduled_at' => $start,
                            ]
                        );

                        $appointmentCreated = true;
                        break;
                    }
                }

                // Move to next day if no slot found
                if (! $appointmentCreated) {
                    $date->addDay()->startOfDay();
                }
            }
        }

        return ComplaintResource::make($complaint->load('witnesses', 'customFieldValues.customField', 'appointments'))
            ->additional(['message' => 'Complaint updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint)
    {
        //
    }

}
