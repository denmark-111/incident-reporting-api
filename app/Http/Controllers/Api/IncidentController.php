<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIncidentRequest;
use App\Http\Requests\UpdateIncidentRequest;
use App\Http\Resources\IncidentResource;
use App\Models\Incident;
use Illuminate\Support\Facades\Storage;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $incidents = $user->isAdmin()
            ? Incident::all()
            : $user->incidents()->get();

        return IncidentResource::collection($incidents);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIncidentRequest $request)
    {
        $data = $request->validated();

        // Handle file upload if present
        if ($request->hasFile('evidence')) {
            $path = $request->file('evidence')->store('evidence', 'public');
            $data['evidence_path'] = $path;
        }

        $incident = $request->user()->incidents()->create($data);

        return IncidentResource::make($incident)
            ->additional(['message' => 'Incident created successfully'])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Incident $incident)
    {
        $this->authorizeIncident($incident);

        return IncidentResource::make($incident);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIncidentRequest $request, Incident $incident)
    {
        $this->authorizeIncident($incident);

        $data = $request->validated();

        // Handle file upload if present
        if ($request->hasFile('evidence')) {
            // Delete old file if exists
            if ($incident->evidence_path && Storage::disk('public')->exists($incident->evidence_path)) {
                Storage::disk('public')->delete($incident->evidence_path);
            }

            $path = $request->file('evidence')->store('evidence', 'public');
            $data['evidence_path'] = $path;
        }

        $incident->update($data);

        return IncidentResource::make($incident)
            ->additional(['message' => 'Incident updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incident $incident)
    {
        //
    }

    private function authorizeIncident(Incident $incident)
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return;
        }

        if ($incident->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }
    }
}
