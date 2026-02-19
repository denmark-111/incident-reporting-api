<?php

namespace Database\Seeders;

use App\Models\IncidentType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Brian Dijamco',
            'email' => 'brian.dijamco@gmail.com',
            'username' => 'brian.dijamco',
        ]);

        User::factory()->create([
            'name' => 'Denmarc Maglipon',
            'email' => 'denmarc.maglipon@gmail.com',
            'username' => 'denmarc.maglipon',
        ]);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
        ]);

        
        $defaultIncidentTypes = [
            'Waste Management ',
            'Flooding',
            'Pollution',
            'Traffic ',
            'Infrastructure',
            'Water Supply',
            'Public Safety',
        ];

        foreach ($defaultIncidentTypes as $type) {
            IncidentType::firstOrCreate(
                ['name' => $type],
                ['is_custom' => false]
            );
        }
    }
}
