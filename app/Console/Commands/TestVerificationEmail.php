<?php

namespace App\Console\Commands;

use App\Mail\VerificationCode as VerificationCodeMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestVerificationEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:verification-email {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía un email de prueba con código de verificación';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $testCode = '123456';

        try {
            Mail::to($email)->send(new VerificationCodeMail($testCode, $email));
            $this->info("Email de prueba enviado exitosamente a: {$email}");
            $this->info("Código de prueba: {$testCode}");
        } catch (\Exception $e) {
            $this->error("Error al enviar email: " . $e->getMessage());
            $this->error("Línea: " . $e->getLine());
            $this->error("Archivo: " . $e->getFile());
        }

        return Command::SUCCESS;
    }
}
