<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FacultyFactory extends Factory
{
    protected $model = \App\Models\Faculty::class;

    public function definition(): array
    {
        return [
            'name' => 'FACULTAD DE ' . strtoupper($this->faker->words(3, true)),
            'code' => strtoupper($this->faker->unique()->lexify('F????')),
            'description' => $this->faker->sentence(),
        ];
    }
}
