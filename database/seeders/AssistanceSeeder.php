<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assistance;

class AssistanceSeeder extends Seeder
{
    public function run(): void
    {
        $targetCount = 10000;
        $existingCount = \App\Models\Assistance::count();
        
        if ($existingCount >= $targetCount) {
            $this->command->info("Ya existen {$existingCount} asistencias, que es igual o mayor a {$targetCount}.");
            return;
        }
        
        $needToCreate = $targetCount - $existingCount;
        $this->command->info("Generando {$needToCreate} asistencias para llegar a un mínimo de {$targetCount}...");
        
        // Crear en lotes para mejor rendimiento
        $batchSize = 500;
        $progressBar = $this->command->getOutput()->createProgressBar($needToCreate);
        $progressBar->start();
        
        for ($i = 0; $i < $needToCreate; $i += $batchSize) {
            $count = min($batchSize, $needToCreate - $i);
            Assistance::factory()->count($count)->create();
            $progressBar->advance($count);
        }
        
        $progressBar->finish();
        $this->command->newLine();
        $this->command->info("Se han creado asistencias. Total actual: " . \App\Models\Assistance::count());
    }
}
