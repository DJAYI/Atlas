<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * 
         * ACTIVIDAD MULTICULTURAL
CATEDRA ABIERTA
CATEDRA MULTICULTURAL
CLASE ESPEJO
COIL
CONFERENCIA
CURSO CORTO
DOCENTE INVITADO
OLIMPIADAS
PARTICIPACION EN RED
PASANTIA DE INVESTIGACION
PONENCIA
RETO 
REUNION
REUNION 
RUTA ACADEMICA 
ASIGNATURA

class Activity extends Model
{
    protected $fillable = ['name', 'description'];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}

         */

        DB::table('activities')->insert([
            [
                'name' => 'Cátedra Abierta',
                'description' => 'Espacio académico donde se abordan temas de interés general.',
            ],
            [
                'name' => 'Cátedra Multicultural',
                'description' => 'Espacio académico que promueve la diversidad cultural.',
            ],
            [
                'name' => 'Clase Espejo',
                'description' => 'Clase en la que se comparte conocimiento entre diferentes instituciones.',
            ],
            [
                'name' => 'COIL',
                'description' => 'Collaborative Online International Learning, aprendizaje colaborativo en línea internacional.',
            ],
            [
                'name' => 'Conferencia',
                'description' => 'Evento académico donde un experto presenta un tema específico.',
            ],
            [
                'name' => 'Curso Corto',
                'description' => 'Programa académico breve sobre un tema específico.',
            ],
            [
                'name' => 'Docente Invitado',
                'description' => 'Profesor externo que imparte clases o conferencias.',
            ],
            [
                'name' => 'Olimpiadas',
                'description' => 'Competencia académica entre estudiantes de diferentes instituciones.',
            ],
            [
                'name' => 'Participación en Red',
                'description' => 'Colaboración y participación en redes académicas o profesionales.',
            ],
            [
                'name' => 'Pasantía de Investigación',
                'description' => 'Experiencia práctica en investigación en una institución diferente.',
            ],
            [
                'name' => 'Ponencia',
                'description' => 'Presentación oral sobre un tema específico en un evento académico.',
            ],
            [
                'name' => 'Reto Académico',
                'description' => 'Desafío propuesto a estudiantes para fomentar el aprendizaje.',
            ],
            [
                'name' => 'Reunión Académica',
                'description' => 'Encuentro entre académicos para discutir temas de interés.',
            ],
            [
                'name' => 'Ruta Académica',
                'description' => 'Itinerario académico que incluye diferentes actividades y eventos.',
            ],
            [
                'name' => 'Asignatura',
                'description' => 'Curso o materia específica dentro de un programa académico.',
            ],
        ]);
    }
}
