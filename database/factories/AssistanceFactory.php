<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Person;
use App\Models\University;
use App\Models\Mobility;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssistanceFactory extends Factory
{
    public function definition(): array
    {
        static $events = null;
        static $people = null;
        static $universities = null;
        static $mobilities = null;
        
        // Cargar los datos solo una vez para mejorar rendimiento
        if ($events === null) {
            $events = Event::all();
            if ($events->isEmpty()) {
                $events = collect([Event::factory()->create()]);
            }
        }
        
        if ($people === null) {
            $people = Person::all();
            if ($people->isEmpty()) {
                $people = collect([Person::factory()->create()]);
            }
        }
        
        if ($universities === null) {
            $universities = University::all();
            if ($universities->isEmpty()) {
                $universities = collect([University::factory()->create()]);
            }
        }
        
        if ($mobilities === null) {
            $mobilities = Mobility::all();
            if ($mobilities->isEmpty()) {
                // Para crear una movilidad manualmente si no hay ninguna
                $mobility = new Mobility();
                $mobility->name = 'Default Mobility';
                $mobility->save();
                $mobilities = collect([$mobility]);
            }
        }
        
        // Seleccionar elementos aleatoriamente de las colecciones cargadas
        $event = $events->random();
        $person = $people->random();
        $universityDestiny = $universities->random();
        $mobility = $mobilities->random();
        
        // Calcular fecha de creación
        if ($event && $event->start_date) {
            $eventStart = \Carbon\Carbon::parse($event->start_date);
        } else {
            $eventStart = now();
        }
        
        // created_at para asistencia: entre eventStart - 30 días y eventStart, pero nunca después de now
        $createdAtEnd = min($eventStart, now());
        $createdAtStart = (clone $createdAtEnd)->subDays(30);
        if ($createdAtStart > $createdAtEnd) {
            $createdAtStart = $createdAtEnd;
        }
        $createdAt = $this->faker->dateTimeBetween($createdAtStart, $createdAtEnd);
        
        return [
            'event_id' => $event->id,
            'person_id' => $person->id,
            'university_destiny_id' => $universityDestiny->id,
            'mobility_id' => $mobility->id,
            'identity_document_file' => null,
            'created_at' => $createdAt->format('Y-m-d H:i:s'),
            'updated_at' => $createdAt->format('Y-m-d H:i:s'),
        ];
    }
}
