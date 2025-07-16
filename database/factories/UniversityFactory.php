<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class UniversityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'country_id' => \App\Models\Country::factory(),
            'name' => $this->faker->company . ' University',
            'code' => strtoupper($this->faker->unique()->lexify('U????')),
            'description' => $this->faker->sentence,
        ];
    }
}
