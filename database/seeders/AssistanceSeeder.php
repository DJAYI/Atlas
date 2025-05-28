<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assistance;

class AssistanceSeeder extends Seeder
{
    public function run(): void
    {
        Assistance::factory(rand(8, 1000))->create();
    }
}
