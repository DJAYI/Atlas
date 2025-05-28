<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AgreementFactory extends Factory
{
    public function definition(): array
    {
        $types = ['marco', 'especifico'];
        $activities = ['formacion', 'investigacion', 'extension', 'administrativa', 'otra'];
        return [
            'year' => $this->faker->year,
            'semester' => $this->faker->randomElement(['1', '2']),
            'code' => strtoupper($this->faker->unique()->lexify('??????')),
            'type' => $this->faker->randomElement($types),
            'activity' => $this->faker->randomElement($activities),
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
        ];
    }
}
