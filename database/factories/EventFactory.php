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
        $now = now();
        $currentYear = $now->year;
        $yearStart = $currentYear - 2;
        $yearEnd = $currentYear - 1;
        $startDate = $this->faker->dateTimeBetween("$yearStart-01-01", "$yearEnd-12-31");
        $monthlyStart = $now->copy()->subYear();
        $monthlyEnd = $now->copy()->subDay();
        $isMonthly = $this->faker->boolean(30);
        if ($isMonthly && $monthlyStart < $monthlyEnd) {
            $startDate = $this->faker->dateTimeBetween($monthlyStart, $monthlyEnd);
        }
        // Ensure end_date is always >= start_date
        $daysToAdd = rand(0, 10);
        $endDate = (clone $startDate)->modify("+{$daysToAdd} days");
        // created_at should be before or equal to start_date, but not after now
        $createdAtEnd = min($startDate, $now);
        $createdAtStart = (clone $createdAtEnd)->modify('-2 years');
        if ($createdAtStart > $createdAtEnd) {
            $createdAtStart = $createdAtEnd;
        }
        $createdAt = $this->faker->dateTimeBetween($createdAtStart, $createdAtEnd);
        return [
            'name' => $this->faker->catchPhrase,
            'responsable' => $this->faker->name,
            'activity_id' => Activity::inRandomOrder()->first()?->id,
            'event_code' => strtoupper($this->faker->unique()->lexify('?????')),
            'modality' => $this->faker->randomElement($modalities),
            'location' => $this->faker->randomElement($locations),
            'internationalization_at_home' => $this->faker->randomElement(['si', 'no']),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'start_time' => $this->faker->time('H:i'),
            'end_time' => $this->faker->time('H:i'),
            'created_at' => $createdAt->format('Y-m-d H:i:s'),
            'updated_at' => $createdAt->format('Y-m-d H:i:s'),
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
