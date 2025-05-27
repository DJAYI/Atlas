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
        return [
            'event_id' => Event::factory(),
            'person_id' => Person::factory(),
            'university_destiny_id' => University::factory(),
            'mobility_id' => $this->faker->randomElement(Mobility::all())->id,
            'identity_document_file' => null,
        ];
    }
}
