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
        // Get the event's start_date if possible, else use now
        $event = Event::inRandomOrder()->first();
        if ($event && $event->start_date) {
            $eventStart = \Carbon\Carbon::parse($event->start_date);
        } else {
            $eventStart = now();
        }
        // created_at for assistance: between eventStart - 30 days and eventStart, but never after now
        $createdAtEnd = min($eventStart, now());
        $createdAtStart = (clone $createdAtEnd)->subDays(30);
        if ($createdAtStart > $createdAtEnd) {
            $createdAtStart = $createdAtEnd;
        }
        $createdAt = $this->faker->dateTimeBetween($createdAtStart, $createdAtEnd);
        return [
            'event_id' => Event::factory(),
            'person_id' => Person::factory(),
            'university_destiny_id' => University::factory(),
            'mobility_id' => $this->faker->randomElement(Mobility::all())->id,
            'identity_document_file' => null,
            'created_at' => $createdAt->format('Y-m-d H:i:s'),
            'updated_at' => $createdAt->format('Y-m-d H:i:s'),
        ];
    }
}
