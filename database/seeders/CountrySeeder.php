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
        $response = Http::timeout(30)->get('https://restcountries.com/v3.1/all');

        if ($response->failed()) {
            Country::create([
                'name' => 'Colombia',
                'iso_code' => '170',
                'iso_code_alpha_3' => 'COL',
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
