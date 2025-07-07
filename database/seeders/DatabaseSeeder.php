<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\University;
use App\Models\Country;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CountrySeeder::class,
            MobilitiesSeeder::class,
            FacultiesSeeder::class,
            ActivitiesSeeder::class,
            CareersSeeder::class,
            UniversitySeeder::class,
            RoleAndPermissionSeeder::class, // Add roles and permissions
            // PersonSeeder::class,
            UserSeeder::class, // Create users with roles
            // EventSeeder::class,
        ]);
    }
}
