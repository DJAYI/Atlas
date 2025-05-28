<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agreement;

class AgreementSeeder extends Seeder
{
    public function run(): void
    {
        Agreement::factory(rand(8, 50))->create();
    }
}
