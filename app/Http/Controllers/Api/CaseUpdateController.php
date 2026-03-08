<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Incident;
use Illuminate\Http\Request;

class CaseUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Complaint $complaint = null, Incident $incident = null)
    {
        $validated = $request->validate([
            'message' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        // Determine if the update is for a complaint or an incident (based on route since this is nested in both complaint and incident)
        $parent = $complaint ?? $incident;

        if (! $parent) {
            abort(404);
        }

        if($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('case_updates', 'public');
            $validated['attachment_path'] = $path;
        }

        $parent->caseUpdates()->create([
            ...$validated,
            'user_id' => auth()->id(),
            'event_type' => isset($validated['attachment_path']) ? 'attachment_added' : 'note_added',
        ]);

        return response()->json(['message' => 'Case update added successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
