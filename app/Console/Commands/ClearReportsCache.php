<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearReportsCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:clear-reports {--force : Force clearing all reports cache}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear reports and dashboard cache for better performance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $force = $this->option('force');
        
        $this->info('Clearing reports cache...');
        
        // Claves de caché específicas para reportes
        $cacheKeys = [
            'all_assistances_export',
            'dashboard_events',
            'dashboard_last_year_events_counts',
            'dashboard_last_year_assistances_counts',
            'dashboard_last_year_careers_counts',
            'dashboard_last_year_unique_participants_counts',
            'dashboard_last_year_events_per_month',
            'dashboard_last_year_assistances_per_month',
            'dashboard_last_year_careers_per_month',
            'dashboard_last_year_unique_participants_per_month',
        ];

        $cleared = 0;
        foreach ($cacheKeys as $key) {
            if (Cache::forget($key)) {
                $cleared++;
                $this->line("✓ Cleared: {$key}");
            }
        }

        // Limpiar caché de estadísticas por años
        $currentYear = now()->year;
        for ($i = $currentYear - 2; $i <= $currentYear; $i++) {
            $yearKeys = [
                "assistance_stats_{$i}",
                "events_for_year_{$i}",
            ];
            
            foreach ($yearKeys as $key) {
                if (Cache::forget($key)) {
                    $cleared++;
                    $this->line("✓ Cleared: {$key}");
                }
            }
        }

        if ($force) {
            // Limpiar todo el caché si se usa --force
            Cache::flush();
            $this->info('All cache cleared!');
        }

        $this->info("Reports cache cleared successfully! ({$cleared} keys cleared)");
        
        return 0;
    }
}
