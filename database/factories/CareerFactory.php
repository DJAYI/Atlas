<?php

namespace Database\Factories;

use App\Models\Faculty;
use Illuminate\Database\Eloquent\Factories\Factory;

class CareerFactory extends Factory
{
    protected $model = \App\Models\Career::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->jobTitle() . ' en ' . $this->faker->word(),
            'description' => $this->faker->sentence(),
            'faculty_id' => Faculty::inRandomOrder()->first()?->id ?? Faculty::factory(),
        ];
    }
}
