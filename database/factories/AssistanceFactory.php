<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assistance>
 */
class AssistanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Assistance::class;

    public function definition(): array
    {
        return [
            'event_id' => 1,
            'person_id' => 1,
            'university_destiny_id' => 1,
            'mobility_id' => 1,
            'identity_document_file' => null
        ];
    }
}
