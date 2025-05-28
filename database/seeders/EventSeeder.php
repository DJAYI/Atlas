<?php

namespace Database\Seeders;

use App\Models\Agreement;
use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $agreements = Agreement::all();
        foreach ($agreements as $agreement) {
            Event::factory(rand(1, 4))->create([
                'has_agreement' => 'si',
                'agreement_id' => $agreement->id,
            ]);
        }

        Event::factory(rand(1, 6))->create([
            'agreement_id' => null,
            'has_agreement' => 'no',
        ]);
    }
}
