<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComplaintRequest;
use App\Http\Requests\UpdateComplaintRequest;
use App\Http\Resources\ComplaintResource;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'status'        => ['sometimes', 'string'],
            'severity'      => ['sometimes', 'string'],
            'type'          => ['sometimes', 'string'],
            'start_date'    => ['sometimes', 'date'],
            'end_date'      => ['sometimes', 'date', 'after_or_equal:start_date'],
            'per_page'      => ['sometimes', 'integer', 'min:1', 'max:100'],
        ]);

        $user = auth()->user();

        $query = $user->isAdmin()
            ? Complaint::with('witnesses')
            : $user->complaints()->with('witnesses');

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

        return ComplaintResource::make($complaint->load('witnesses'))
            ->additional(['message' => 'Complaint created successfully'])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Complaint $complaint)
    {
        $this->authorizeComplaint($complaint);

        return ComplaintResource::make($complaint->load('witnesses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComplaintRequest $request, Complaint $complaint)
    {
        $this->authorizeComplaint($complaint);
        
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

        return ComplaintResource::make($complaint->load('witnesses'))
            ->additional(['message' => 'Complaint updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint)
    {
        //
    }

    private function authorizeComplaint(Complaint $complaint)
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return;
        }

        if ($complaint->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }
    }
}
