<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FinancialEntity;

class FinancialEntitySeeder extends Seeder
{
    public function run(): void
    {
        FinancialEntity::factory(rand(8, 50))->create();
    }
}
