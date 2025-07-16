<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    protected $model = \App\Models\Country::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->country(),
            'iso_code_alpha_3' => strtoupper($this->faker->unique()->lexify('???')),
            'iso_code' => $this->faker->unique()->numberBetween(100, 999),
        ];
    }
}
