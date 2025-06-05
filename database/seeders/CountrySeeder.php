<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get('https://restcountries.com/v3.1/all?fields=name,ccn3,cca3');

        if ($response->failed()) {
            $this->command->error('Error fetching countries from API.');
            Country::create([
                'name' => 'Colombia',
                'iso_code' => '170',
                'iso_code_alpha_3' => 'COL',
            ]);

            Country::create([
                'name' => 'Venezuela',
                'iso_code' => '862',
                'iso_code_alpha_3' => 'VEN',
            ]);
            return;
        }

        $data = $response->json();

        foreach ($data as $country) {
            Country::create([
                'name' => $country['name']['common'] ?? 'Unknown',
                'iso_code' => $country['ccn3'] ?? '',
                'iso_code_alpha_3' => $country['cca3'] ?? '',
            ]);
        }

        $this->command->info('Countries seeded successfully.');
    }
}
