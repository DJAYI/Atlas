<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class UniversityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'country_id' => Country::inRandomOrder()->first()?->id ?? 1,
            'name' => $this->faker->company . ' University',
            'code' => strtoupper($this->faker->unique()->lexify('U????')),
            'description' => $this->faker->sentence,
        ];
    }
}
