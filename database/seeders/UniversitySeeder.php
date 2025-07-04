<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use App\Models\University;

class UniversitySeeder extends Seeder
{
    public function run(): void
    {
        // University::factory(rand(8, 10))->create();
        University::create([
            'name' => 'Fundación Universitaria Tecnológico Comfenalco',
            'code' => 'FUTC',
            'description' => 'Fundación Universitaria Tecnológico Comfenalco es una institución de educación superior ubicada en Colombia, enfocada en ofrecer programas académicos de alta calidad y formación integral a sus estudiantes.',
            'country_id' => Country::where('name', 'Colombia')->first()->id,
        ]);
    }
}
