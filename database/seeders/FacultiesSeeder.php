<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('faculties')->insert([
            [
                'name' => 'FACULTAD DE CIENCIAS ECONÓMICAS, ADMINISTRATIVAS Y CONTABLES',
                'description' => 'La Fundación Universitaria Tecnológico Comfenalco, ubicada en Cartagena de Indias, Bolívar, Colombia, ofrece programas académicos en áreas como economía, administración y contabilidad.',
                'code' => 'FCEAC',
            ],
            [
                'name' => 'FACULTAD DE CIENCIAS SOCIALES Y EDUCACIÓN',
                'description' => 'La Fundación Universitaria Tecnológico Comfenalco, ubicada en Cartagena de Indias, Bolívar, Colombia, ofrece programas académicos en áreas como psicología, trabajo social y educación.',
                'code' => 'FCSE',
            ],
            [
                'name' => 'FACULTAD DE INGENIERÍA',
                'description' => 'La Fundación Universitaria Tecnológico Comfenalco, ubicada en Cartagena de Indias, Bolívar, Colombia, ofrece programas académicos en áreas como ingeniería civil, ingeniería industrial e ingeniería de sistemas.',
                'code' => 'FI',
            ],
        ]);
    }
}
