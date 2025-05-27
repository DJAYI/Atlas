<?php

namespace Database\Factories;

use App\Models\Career;
use App\Models\Country;
use App\Models\University;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    public function definition(): array
    {
        $genres = ['M', 'F', 'O', 'PND'];
        $types = ['estudiante', 'profesor'];
        $minorities = [
            'afrodescendiente',
            'indigena',
            'gitano',
            'LGTBISQ+',
            'discapacitado',
            'victima de conflicto armado',
            'desplazado',
            null
        ];
        $docTypes = ['CC', 'CE', 'TI', 'PP', 'DNI', 'CA', 'Otro'];
        return [
            'firstname' => $this->faker->firstName,
            'middlename' => $this->faker->optional()->firstName,
            'lastname' => $this->faker->lastName,
            'second_lastname' => $this->faker->optional()->lastName,
            'document_type' => $this->faker->randomElement($docTypes),
            'document_number' => $this->faker->unique()->numerify('##########'),
            'email' => $this->faker->unique()->safeEmail,
            'institutional_email' => $this->faker->unique()->companyEmail,
            'phone' => $this->faker->optional()->phoneNumber,
            'genre' => $this->faker->randomElement($genres),
            'birth_date' => $this->faker->date('Y-m-d', '-18 years'),
            'minority' => $this->faker->randomElement($minorities),
            'country_id' => Country::inRandomOrder()->first()?->id ?? 1,
            'type' => $this->faker->randomElement($types),
            'career_id' => Career::inRandomOrder()->first()?->id,
            'university_id' => University::inRandomOrder()->first()?->id,
        ];
    }
}
