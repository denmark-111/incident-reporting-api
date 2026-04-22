<?php

namespace Database\Seeders;

use App\Models\Incident;
use App\Models\IncidentType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class IncidentSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::pluck('id');
        $types = IncidentType::pluck('id');

        $incidents = [
            [
                'description' => 'Flooding due to clogged drainage after heavy rain.',
                'location' => 'Masaya Street, Barangay Gulod',
                'latitude' => 14.708262,
                'longitude' => 121.042752,
                'additional_notes' => 'Water reached knee level.',
                'evidence_path' => 'evidence/incident1.jpg',
                'custom_type' => 'Flooding',
            ],
            [
                'description' => 'Broken streetlight causing dark road at night.',
                'location' => 'Nellie Street, Barangay Gulod',
                'latitude' => 14.709868,
                'longitude' => 121.040296,
                'additional_notes' => 'Safety concern for pedestrians.',
                'evidence_path' => 'evidence/incident2.jpg',
                'custom_type' => 'Infrastructure',
            ],
        ];

        foreach ($incidents as $data) {

            // Extract custom type
            $customTypeName = $data['custom_type'];
            unset($data['custom_type']);

            // Copy evidence file
            $filename = basename($data['evidence_path']);
            $source = database_path("seeders/files/evidence/$filename");
            $destination = "evidence/$filename";

            if (File::exists($source)) {
                if (!Storage::disk('public')->exists($destination)) {
                    Storage::disk('public')->put($destination, File::get($source));
                }
            }

            $incident = Incident::create([
                'user_id' => $users->random(),
                ...$data,
                'evidence_path' => $destination,
                'status' => 'pending',
            ]);

            // Create custom type
            $type = IncidentType::firstOrCreate(
                ['name' => $customTypeName],
                ['is_custom' => true]
            );

            $incident->types()->attach($type->id);
        }
    }
}