<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomFieldRequest;
use App\Http\Requests\UpdateCustomFieldRequest;
use App\Http\Resources\CustomFieldResource;
use App\Models\CustomField;

class CustomFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CustomFieldResource::collection(CustomField::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomFieldRequest $request)
    {
        $validated = $request->validated();

        $customField = CustomField::create([
            'field_name' => strtolower(str_replace(' ', '_', $validated['field_label'])),
            'field_for' => $validated['field_for'],
            'field_label' => $validated['field_label'],
            'field_type' => $validated['field_type'],
            'field_description' => $validated['field_description'] ?? null,
            'field_options' => isset($validated['field_options']) ? json_encode($validated['field_options']) : null,
            'field_rules' => $validated['field_rules'] ?? null,
            'is_active' => $validated['is_active'] ?? false
        ]);

        return CustomFieldResource::make($customField)
            ->additional(['message' => 'Custom field created successfully.'])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomField $customField)
    {
        return CustomFieldResource::make($customField);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomFieldRequest $request, CustomField $customField)
    {
        $validated = $request->validated();

        if (isset($validated['field_label'])) {
            $validated['field_name'] = strtolower(str_replace(' ', '_', $validated['field_label']));
        }

        if (isset($validated['field_options'])) {
            $validated['field_options'] = json_encode($validated['field_options']);
        }

        $customField->update($validated);

        return CustomFieldResource::make($customField)
            ->additional(['message' => 'Custom field updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomField $customField)
    {
        //
    }
}
