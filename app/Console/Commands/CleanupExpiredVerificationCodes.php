<?php

namespace App\Console\Commands;

use App\Models\VerificationCode;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CleanupExpiredVerificationCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:cleanup-verification-codes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpia códigos de verificación usados';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $usedCount = VerificationCode::where('used', true)->count();

        if ($usedCount > 0) {
            VerificationCode::where('used', true)->delete();

            $this->info("Se eliminaron {$usedCount} códigos de verificación usados.");
        } else {
            $this->info('No hay códigos de verificación usados para limpiar.');
        }

        return Command::SUCCESS;
    }
}
