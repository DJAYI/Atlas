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
use App\Models\Faculty;
use App\Models\Mobility;

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

        Mobility::create([
            'name' => 'Mobility 1',
            'type' => 'estudiante'
        ]);

        Mobility::create([
            'name' => 'Mobility 2',
            'type' => 'profesor'
        ]);

        Mobility::create([
            'name' => 'Mobility 3',
            'type' => 'egresado'
        ]);

        Mobility::create([
            'name' => 'Mobility 4',
            'type' => 'administrativo'
        ]);

        Country::create([
            'id' => 1,
            'name' => 'MEXICO',
            'iso_code_alpha-3' => '484',
            'iso_code' => 'MEX',
        ]);

        Country::create([
            'id' => 2,
            'name' => 'COLOMBIA',
            'iso_code_alpha-3' => '170',
            'iso_code' => 'COL',
        ]);


        University::create([
            'name' => 'FUNDACIÓN UNIVERSITARIA TECNOLÓGICO COMFENALCO',
            'description' => 'La Fundación Universitaria Tecnológico Comfenalco, ubicada en Cartagena de Indias, Bolívar, Colombia, ofrece programas académicos en diversas áreas del conocimiento.',
            'code' => 'FUTC',
            'country_id' => 2,
        ]);

        Faculty::create([
            'name' => 'FACULTAD DE CIENCIAS ECONÓMICAS, ADMINISTRATIVAS Y CONTABLES',
            'description' => 'La Fundación Universitaria Tecnológico Comfenalco, ubicada en Cartagena de Indias, Bolívar, Colombia, ofrece programas académicos en áreas como economía, administración y contabilidad.',
            'code' => 'FCEAC',
        ]);

        Faculty::create([
            'name' => 'FACULTAD DE CIENCIAS SOCIALES Y EDUCACIÓN',
            'description' => 'La Fundación Universitaria Tecnológico Comfenalco, ubicada en Cartagena de Indias, Bolívar, Colombia, ofrece programas académicos en áreas como psicología, trabajo social y educación.',
            'code' => 'FCSE',
        ]);

        Faculty::create([
            'name' => 'FACULTAD DE INGENIERÍA',
            'description' => 'La Fundación Universitaria Tecnológico Comfenalco, ubicada en Cartagena de Indias, Bolívar, Colombia, ofrece programas académicos en áreas como ingeniería civil, ingeniería industrial e ingeniería de sistemas.',
            'code' => 'FI',
        ]);
    }
}
