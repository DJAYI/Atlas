<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MobilitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mobilities = [
            // Estudiantes
            ['name' => 'Pasantía o práctica', 'type' => 'estudiante'],
            ['name' => 'Misión', 'type' => 'estudiante'],
            ['name' => 'Curso corto', 'type' => 'estudiante'],
            ['name' => 'Asistencia a eventos', 'type' => 'estudiante'],
            ['name' => 'Rotación Médica', 'type' => 'estudiante'],
            ['name' => 'Semestre académico de Intercambio', 'type' => 'estudiante'],
            ['name' => 'Doble Titulación', 'type' => 'estudiante'],

            // Administrativos
            ['name' => 'Misión', 'type' => 'administrativo'],
            ['name' => 'Asistencia a eventos', 'type' => 'administrativo'],
            ['name' => 'Curso Corto', 'type' => 'administrativo'],
            ['name' => 'Pasantía', 'type' => 'administrativo'],
            ['name' => 'Gestión de convenios', 'type' => 'administrativo'],

            // Docentes
            ['name' => 'Profesor Visitante', 'type' => 'profesor'],
            ['name' => 'Asistencia a eventos', 'type' => 'profesor'],
            ['name' => 'Misión', 'type' => 'profesor'],
            ['name' => 'Curso Corto', 'type' => 'profesor'],
            ['name' => 'Estancia de Investigación', 'type' => 'profesor'],
            ['name' => 'Profesor Programa Pregrado', 'type' => 'profesor'],
            ['name' => 'Profesor Programa Especialización', 'type' => 'profesor'],
            ['name' => 'Profesor Programa Maestría', 'type' => 'profesor'],
            ['name' => 'Profesor Programa Doctorado', 'type' => 'profesor'],
            ['name' => 'Profesor Programa Posdoctorado', 'type' => 'profesor'],

            // Egresados
            ['name' => 'Asistencia a eventos', 'type' => 'egresado'],
            ['name' => 'Misión', 'type' => 'egresado'],
            ['name' => 'Curso Corto', 'type' => 'egresado'],
            ['name' => 'Gestión de convenios', 'type' => 'egresado'],
            ['name' => 'Doble Titulación', 'type' => 'egresado'],
            ['name' => 'Conversatorio', 'type' => 'egresado'],

        ];

        DB::table('mobilities')->insert($mobilities);
    }
}
