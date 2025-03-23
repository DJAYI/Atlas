<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Database\Factories\CityFactory;
use Database\Factories\CountryFactory;
use Database\Factories\StateFactory;
use Database\Factories\UniversityFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\State;
use App\Models\University;
use App\Models\Activity;
use App\Models\Agreement;
use App\Models\City;
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

        Country::create([
            'id' => 1,
            'name' => 'MEXICO',
            'iso_code_alpha-3' => '484',
            'iso_code' => 'MEX',
        ]);

        State::create([
            'id' => 1,
            'country_id' => 1,
            'name' => 'CIUDAD DE MEXICO',
            'code' => 'CDMX',
        ]);

        City::create([
            'id' => 1,
            'state_id' => 1,
            'name' => 'CIUDAD DE MEXICO',
            'code' => 'CDMX',
        ]);

        University::create([
            'id' => 1,
            'city_id' => 1,
            'name' => 'UNIVERSIDAD AUTONOMA DE MEXICO',
            'code' => 'UAM',
            'description' => 'Universidad Autonoma de Mexico',
        ]);

        University::create([
            'id' => 2,
            'city_id' => 1,
            'name' => 'Universidad de Sonora',
            'code' => 'US',
            'description' => '',
        ]);

        Activity::create([
            'id' => 1,
            'name' => 'Congreso',
            'description' => 'Congreso',
        ]);
    }
}
