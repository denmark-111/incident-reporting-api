<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIncidentRequest;
use App\Http\Requests\UpdateIncidentRequest;
use App\Http\Resources\IncidentResource;
use App\Models\Incident;
use App\Models\IncidentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'status'        => ['sometimes', 'string'],
            'type'          => ['sometimes', 'string'],
            'start_date'    => ['sometimes', 'date'],
            'end_date'      => ['sometimes', 'date', 'after_or_equal:start_date'],
            'per_page'      => ['sometimes', 'integer', 'min:1', 'max:100'],
        ]);

        $user = auth()->user();

        $query = $user->isAdmin()
            ? Incident::with('types')
            : $user->incidents()->with('types');

        // Filter by status
        $query->when($request->status, function ($q) use ($request) {
            $q->where('status', $request->status);
        });

        // Filter by type
        $query->when($request->type, function ($q) use ($request) {
            $q->whereHas('types', function ($sub) use ($request) {
                $sub->where('name', $request->type);
            });
        });

        // Filter by start date
        $query->when($request->start_date, function ($q) use ($request) {
            $q->whereDate('created_at', '>=', $request->start_date);
        });

        // Filter by end date
        $query->when($request->end_date, function ($q) use ($request) {
            $q->whereDate('created_at', '<=', $request->end_date);
        });

        $perPage = $request->per_page ?? 10;

        // Paginate and preserve query parameters in pagination links
        $paginated = $query->latest()->paginate($perPage)
            ->appends($request->only([
                'status', 'type', 'start_date', 'end_date',  'per_page'
            ]));

        return IncidentResource::collection($paginated);
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

        $incident = $request->user()->incidents()->create([
            'description' => $data['description'],
            'location' => $data['location'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'additional_notes' => $data['additional_notes'] ?? null,
            'evidence_path' => $data['evidence_path'] ?? null,
            'status' => 'pending'
        ]);

        // Attach selected default types (type_id)
        $incident->types()->attach($data['types'] ?? []);

        // Handle custom types
        if (!empty($data['custom_types'])) {
            foreach ($data['custom_types'] as $customName) {
                $type = IncidentType::firstOrCreate(
                    ['name' => $customName],
                    ['is_custom' => true]
                );

                $incident->types()->attach($type->id);
            }
        }

        return IncidentResource::make($incident->load('types'))
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

        return IncidentResource::make($incident->load('types'));
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

        // If types present in request → sync
        if ($request->has('types') || $request->has('custom_types')) {

            $typeIds = $data['types'] ?? [];

            if (!empty($data['custom_types'])) {
                foreach ($data['custom_types'] as $customName) {
                    $type = IncidentType::firstOrCreate(
                        ['name' => $customName],
                        ['is_custom' => true]
                    );

                    $typeIds[] = $type->id;
                }
            }

            $incident->types()->sync($typeIds);
        }

        return IncidentResource::make($incident->load('types'))
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
