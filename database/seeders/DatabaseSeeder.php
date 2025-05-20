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

        User::create([
            'username' => 'Admin',
            'email' => 'test@mail.com',
            'institutional_email' => 'academic@mail.com',
            'password' => 'password',
        ]);


        $this->call([
            CountrySeeder::class,
            MobilitiesSeeder::class,
            FacultiesSeeder::class,
            ActivitiesSeeder::class,
            CareersSeeder::class
        ]);

        University::create([
            'name' => 'FUNDACIÓN UNIVERSITARIA TECNOLÓGICO COMFENALCO',
            'description' => 'La Fundación Universitaria Tecnológico Comfenalco, ubicada en Cartagena de Indias, Bolívar, Colombia, ofrece programas académicos en diversas áreas del conocimiento.',
            'code' => 'FUTC',
            'country_id' => Country::where('name', 'Colombia')->first()->id,
        ]);
    }
}
