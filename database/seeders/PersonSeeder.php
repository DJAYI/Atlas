<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Person;
use App\Models\University;

class PersonSeeder extends Seeder
{
    public function run(): void
    {
        $colombiaId = \App\Models\Country::where('name', 'Colombia')->value('id') ?? 1;
        $comfenalco = University::firstOrCreate([
            'code' => 'FUTC'
        ], [
            'name' => 'FUNDACIÓN UNIVERSITARIA TECNOLÓGICO COMFENALCO',
            'description' => 'La Fundación Universitaria Tecnológico Comfenalco, ubicada en Cartagena de Indias, Bolívar, Colombia, ofrece programas académicos en diversas áreas del conocimiento.',
            'country_id' => $colombiaId,
        ]);
        \App\Models\Person::factory(100)->create([
            'type' => 'estudiante',
            'university_id' => $comfenalco->id
        ]);
        \App\Models\Person::factory(100)->create([
            'type' => 'profesor',
            'university_id' => $comfenalco->id
        ]);
        \App\Models\Person::factory(100)->create([
            'type' => 'administrativo',
            'university_id' => $comfenalco->id
        ]);

        \App\Models\Person::factory(100)->create([
            'type' => 'egresado',
            'university_id' => $comfenalco->id
        ]);

        // ...resto del seeder...
        Person::factory(100)->create();
    }
}
