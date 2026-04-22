<?php

namespace Database\Seeders;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ComplaintSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::pluck('id');

        $complaints = [
            [
                'incident_date' => Carbon::now()->subDays(2),
                'incident_time' => '22:30',
                'location' => 'Dexter Street, Barangay Gulod',
                'latitude' => 14.716880,
                'longitude' =>  121.041669,
                'type' => 'noise',
                'severity' => 'medium',
                'description' => 'Loud karaoke sessions past 10PM causing disturbance.',
                'complainant_name' => 'Juan Dela Cruz',
                'complainant_contact' => '09171234567',
                'respondent_name' => 'Pedro Santos',
                'respondent_address' => 'Dexter Street, Barangay Gulod',
                'desired_resolution' => 'Request to limit noise after 10PM',
                'additional_notes' => 'Happens almost every weekend.',
                'evidence_path' => 'evidence/complaint1.jpg',
            ],
            [
                'incident_date' => Carbon::now()->subDays(4),
                'incident_time' => '08:15',
                'location' => 'Granada Street, Barangay Gulod',
                'latitude' => 14.710926,
                'longitude' => 121.041685,
                'type' => 'sanitation',
                'severity' => 'high',
                'description' => 'Garbage not collected for several days.',
                'complainant_name' => 'Maria Santos',
                'complainant_contact' => '09981234567',
                'respondent_name' => 'Barangay Utility',
                'respondent_address' => null,
                'desired_resolution' => 'Immediate garbage collection',
                'additional_notes' => 'Strong odor and pests present.',
                'evidence_path' => 'evidence/complaint2.jpg',
            ],
            [
                'incident_date' => Carbon::now()->subDay(),
                'incident_time' => '07:45',
                'location' => 'San Martin Street, Barangay Gulod',
                'latitude' => 14.711628,
                'longitude' => 121.035686,
                'type' => 'property',
                'severity' => 'low',
                'description' => 'Car parked blocking driveway.',
                'complainant_name' => 'Carlos Reyes',
                'complainant_contact' => '09179876543',
                'respondent_name' => 'Unknown Vehicle Owner',
                'respondent_address' => null,
                'desired_resolution' => 'Clear driveway access',
                'additional_notes' => null,
                'evidence_path' => 'evidence/complaint3.jpg',
            ],
        ];

        foreach ($complaints as $data) {

            // Copy evidence file
            $filename = basename($data['evidence_path']);
            $source = database_path("seeders/files/evidence/$filename");
            $destination = "evidence/$filename";

            if (File::exists($source)) {
                if (!Storage::disk('public')->exists($destination)) {
                    Storage::disk('public')->put($destination, File::get($source));
                }
            }

            $complaint = Complaint::create([
                'user_id' => $users->random(),
                ...$data,
                'evidence_path' => $destination,
                'status' => 'pending',
            ]);

            $complaint->witnesses()->createMany([
                [
                    'name' => 'Ana Lopez',
                    'contact' => '09170000001',
                ],
                [
                    'name' => 'Mark Bautista',
                    'contact' => '09170000002',
                ]
            ]);
        }
    }
}