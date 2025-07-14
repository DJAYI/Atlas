<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Actualizar estadísticas del dashboard cada 6 horas
        $schedule->command('dashboard:update-stats')->everySixHours();
        
        // Actualizar estadísticas del dashboard a las 2 AM cada día para asegurar datos actualizados
        $schedule->command('dashboard:update-stats --force')->dailyAt('02:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
