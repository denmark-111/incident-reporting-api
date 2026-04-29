<?php

namespace Database\Seeders;

use App\Models\IncidentType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            [
                'email' => 'brian.dijamco@gmail.com'],
            [
                'name' => 'Brian Dijamco',
                'username' => 'brian.dijamco',
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            [
                'email' => 'denmarc.maglipon@gmail.com'],
            [
                'name' => 'Denmarc Maglipon',
                'username' => 'denmarc.maglipon',
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'christopher.jonota@gmail.com'],
            [
                'name' => 'Christopher Jonota',
                'username' => 'christopher.jonota',
                'password' => Hash::make('password'),
                'role' => 'staff2',
            ]
        );

        
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

        $this->call([
            ComplaintSeeder::class,
            IncidentSeeder::class,
        ]);
    }
}
