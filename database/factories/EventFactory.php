<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\Agreement;
use App\Models\Assistance;
use App\Models\Country;
use App\Models\Mobility;
use App\Models\Person;
use App\Models\University;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition(): array
    {
        $modalities = ['presencial', 'virtual'];
        $locations = ['nacional', 'internacional', 'local'];
        return [
            'name' => $this->faker->catchPhrase,
            'responsable' => $this->faker->name,
            'activity_id' => Activity::inRandomOrder()->first()?->id,
            'event_code' => strtoupper($this->faker->unique()->lexify('?????')),
            'modality' => $this->faker->randomElement($modalities),
            'location' => $this->faker->randomElement($locations),
            'internationalization_at_home' => $this->faker->randomElement(['si', 'no']),
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'start_time' => $this->faker->time('H:i'),
            'end_time' => $this->faker->time('H:i'),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function ($event) {
            $colombia = \App\Models\Country::firstOrCreate([
                'name' => 'Colombia'
            ], [
                'code' => 'CO',
                'description' => 'País Colombia',
            ]);
            $comfenalco = \App\Models\University::firstOrCreate([
                'code' => 'FUTC'
            ], [
                'name' => 'FUNDACIÓN UNIVERSITARIA TECNOLÓGICO COMFENALCO',
                'description' => 'La Fundación Universitaria Tecnológico Comfenalco, ubicada en Cartagena de Indias, Bolívar, Colombia, ofrece programas académicos en diversas áreas del conocimiento.',
                'country_id' => $colombia->id,
            ]);
            $mobility = \App\Models\Mobility::inRandomOrder()->first();
            // Crear asistentes salientes de ambos tipos
            foreach (['estudiante', 'profesor'] as $tipo) {
                $personasSalientes = \App\Models\Person::where('university_id', $comfenalco->id)->where('type', $tipo)->inRandomOrder()->take(5)->get();
                foreach ($personasSalientes as $person) {
                    \App\Models\Assistance::factory()->create([
                        'event_id' => $event->id,
                        'person_id' => $person->id,
                        'university_destiny_id' => $comfenalco->id,
                        'mobility_id' => $mobility->id,
                    ]);
                }
            }
            $personasComfenalco = \App\Models\Person::where('university_id', $comfenalco->id)->inRandomOrder()->take(5)->get();
            $personasComfenalco->each(function ($person, $i) use ($event, $comfenalco, $mobility) {
                \App\Models\Assistance::factory()->create([
                    'event_id' => $event->id,
                    'person_id' => $person->id,
                    'university_destiny_id' => $i % 2 === 0 ? $comfenalco->id : \App\Models\University::inRandomOrder()->first()->id,
                    'mobility_id' => $mobility->id,
                ]);
            });
            $university = \App\Models\University::inRandomOrder()->first();
            $persons = \App\Models\Person::inRandomOrder()->take(rand(1, 10))->get();
            $persons->each(function ($person) use ($event, $university, $mobility) {
                \App\Models\Assistance::factory()->create([
                    'event_id' => $event->id,
                    'person_id' => $person->id,
                    'university_destiny_id' => $university->id,
                    'mobility_id' => $mobility->id,
                ]);
            });
        });
    }
}
