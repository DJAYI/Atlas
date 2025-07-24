<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\VerificationCode;
use App\Mail\VerificationCode as VerificationCodeMail;
use App\Mail\SuccessfulLogin;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Log;

class TwoFactorController extends Controller
{
    /**
     * Show the two-factor authentication challenge form.
     */
    public function show(): View|RedirectResponse
    {
        if (!session()->has('pending_2fa_email')) {
            return redirect()->route('home', ['locale' => app()->getLocale()]);
        }

        return view('auth.two-factor-challenge');
    }

    /**
     * Verify the two-factor authentication code.
     */
    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'verification_code' => ['required', 'string', 'size:6'],
        ], [
            'verification_code.required' => 'El código de verificación es obligatorio.',
            'verification_code.size' => 'El código de verificación debe tener 6 dígitos.',
        ]);

        $email = session('pending_2fa_email');
        $password = session('pending_2fa_password');
        $remember = session('pending_2fa_remember', false);

        if (!$email || !$password) {
            return redirect()->route('home', ['locale' => app()->getLocale()])
                ->withErrors(['verification_code' => 'Sesión expirada. Por favor, inicia sesión nuevamente.']);
        }

        $code = $request->input('verification_code');

        // Verificar el código 2FA
        if (!VerificationCode::verify($email, $code)) {
            Log::warning('Invalid 2FA code for email: ' . $email . ' at ' . now());
            
            return back()->withErrors([
                'verification_code' => 'El código de verificación es inválido o ya ha sido utilizado.',
            ]);
        }

        // Código válido, autenticar al usuario
        if (!Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            Log::warning('Failed login attempt after 2FA for email: ' . $email . ' at ' . now());
            
            // Limpiar sesión y redirigir
            $this->clearPending2FASession();
            
            return redirect()->route('home', ['locale' => app()->getLocale()])
                ->withErrors(['verification_code' => 'Las credenciales son incorrectas.']);
        }

        // Usuario autenticado exitosamente
        Log::info('User authenticated successfully after 2FA for email: ' . $email . ' at ' . now());

        // Enviar notificación de inicio de sesión exitoso
        $user = Auth::user();
        $this->sendSuccessfulLoginNotification($user, $request);

        // Limpiar sesión 2FA
        $this->clearPending2FASession();
        
        // Limpiar rate limiting
        RateLimiter::clear($this->throttleKey($email, $request->ip()));

        // Regenerar sesión por seguridad
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Resend the two-factor authentication code.
     */
    public function resend(Request $request): RedirectResponse
    {
        $email = session('pending_2fa_email');

        if (!$email) {
            return redirect()->route('home', ['locale' => app()->getLocale()]);
        }

        // Rate limiting para reenvío de códigos
        $key = 'resend-2fa:' . $email;
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'verification_code' => "Demasiados intentos de reenvío. Intenta de nuevo en {$seconds} segundos.",
            ]);
        }

        RateLimiter::hit($key, 300); // 5 minutos

        try {
            // Generar nuevo código
            $code = VerificationCode::generateCode($email);
            
            // Enviar por correo
            Mail::to($email)->send(new VerificationCodeMail($code, $email));
            
            Log::info('2FA code resent to email: ' . $email . ' at ' . now());
            
            return back()->with('status', 'Se ha enviado un nuevo código de verificación a tu correo electrónico.');
            
        } catch (\Exception $e) {
            Log::error('Failed to resend 2FA code: ' . $e->getMessage());
            
            return back()->withErrors([
                'verification_code' => 'Error al enviar el código. Por favor, intenta más tarde.',
            ]);
        }
    }

    /**
     * Clear pending 2FA session data.
     */
    private function clearPending2FASession(): void
    {
        session()->forget([
            'pending_2fa_email',
            'pending_2fa_password',
            'pending_2fa_remember'
        ]);
    }

    /**
     * Get the rate limiting throttle key.
     */
    private function throttleKey(string $email, string $ip): string
    {
        return strtolower($email) . '|' . $ip;
    }

    /**
     * Send successful login notification to user's email
     */
    protected function sendSuccessfulLoginNotification($user, Request $request): void
    {
        try {
            $loginTime = now()->format('d/m/Y H:i:s T');
            $ipAddress = $request->ip();
            $userAgent = $request->header('User-Agent') ?? 'Navegador desconocido';

            Mail::to($user->email)->send(new SuccessfulLogin(
                $user->username,
                $user->email,
                $ipAddress,
                $userAgent,
                $loginTime
            ));

            Log::info('Successful login notification sent to: ' . $user->email . ' at ' . now());
        } catch (\Exception $e) {
            Log::error('Failed to send successful login notification: ' . $e->getMessage());
        }
    }
}
