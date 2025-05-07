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

        $roles = [
            'admin',
            'regen',
            'user'
        ];

        foreach ($roles as $role) {
            \Spatie\Permission\Models\Role::create(['name' => $role]);
        }


        $users = [
            [
                'name' => 'Admin',
                'email' => 'test@mail.com',
                'password' => 'password',
                'institutional_email' => 'test@mail.com',
                'role' => 'admin',
            ],
            [
                'name' => 'Regen',
                'email' => 'regen@mail.com',
                'institutional_email' => 'regen@institution.com',
                'password' => 'password',
                'role' => 'regen',
            ],
        ];

        foreach ($users as $user) {
            $newUser = User::create([
                'username' => $user['name'],
                'email' => $user['email'],
                'institutional_email' => $user['institutional_email'],
                'password' => $user['password'],
            ]);

            $newUser->assignRole($user['role']);
        }


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
