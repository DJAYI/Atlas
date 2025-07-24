<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\TurnstileServiceCF;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $token = $request['cf-turnstile-response'] ?? null;
        $ip = request()->ip();
        $result = (new TurnstileServiceCF())->validate($token, $ip);
        if (!$result) {
            session()->flash('error_captcha', 'La validación de Turnstile falló. Intenta de nuevo.');
            return redirect()->back();
        }

        try {
            $request->authenticate();
            session()->regenerate();
            return redirect()->intended(route('dashboard', absolute: false));
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Si el error contiene 'redirect_to_2fa', redirigir a la vista de 2FA
            if (isset($e->errors()['email']) && in_array('redirect_to_2fa', $e->errors()['email'])) {
                return redirect()->route('2fa.show');
            }
            
            // Para otros errores de validación, volver atrás con errores
            throw $e;
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home', ['locale' => app()->getLocale()]);
    }
}
