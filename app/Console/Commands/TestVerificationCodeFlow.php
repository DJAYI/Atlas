<?php

namespace App\Console\Commands;

use App\Models\VerificationCode;
use Illuminate\Console\Command;

class TestVerificationCodeFlow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:verification-code-flow';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prueba el flujo completo de códigos de verificación sin expiración';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $testEmail = 'test@example.com';
        
        $this->info("=== Prueba de Códigos de Verificación ===");
        
        // 1. Generar código
        $this->info("1. Generando código para: $testEmail");
        $code = VerificationCode::generateCode($testEmail);
        $this->info("   Código generado: $code");
        
        // 2. Verificar código (primera vez - debe funcionar)
        $this->info("2. Verificando código por primera vez...");
        $result1 = VerificationCode::verify($testEmail, $code);
        $this->info("   Resultado: " . ($result1 ? 'EXITOSA ✅' : 'FALLIDA ❌'));
        
        // 3. Verificar código nuevamente (segunda vez - debe fallar)
        $this->info("3. Verificando código por segunda vez (debe fallar)...");
        $result2 = VerificationCode::verify($testEmail, $code);
        $this->info("   Resultado: " . ($result2 ? 'EXITOSA ❌ (ERROR!)' : 'FALLIDA ✅ (esperado)'));
        
        // 4. Verificar código incorrecto
        $this->info("4. Verificando código incorrecto...");
        $result3 = VerificationCode::verify($testEmail, '999999');
        $this->info("   Resultado: " . ($result3 ? 'EXITOSA ❌ (ERROR!)' : 'FALLIDA ✅ (esperado)'));
        
        // 5. Generar nuevo código (debe eliminar el anterior)
        $this->info("5. Generando nuevo código (debe eliminar anteriores)...");
        $newCode = VerificationCode::generateCode($testEmail);
        $this->info("   Nuevo código generado: $newCode");
        
        // 6. Verificar nuevo código
        $this->info("6. Verificando nuevo código...");
        $result4 = VerificationCode::verify($testEmail, $newCode);
        $this->info("   Resultado: " . ($result4 ? 'EXITOSA ✅' : 'FALLIDA ❌'));
        
        $this->info("\n=== RESUMEN ===");
        $allGood = $result1 && !$result2 && !$result3 && $result4;
        $this->info("Estado general: " . ($allGood ? 'TODAS LAS PRUEBAS PASARON ✅' : 'ALGUNAS PRUEBAS FALLARON ❌'));
        
        // Limpiar códigos de prueba
        VerificationCode::where('email', $testEmail)->delete();
        $this->info("Códigos de prueba eliminados.");

        return Command::SUCCESS;
    }
}
