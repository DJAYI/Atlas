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
        $request->authenticate();
        session()->regenerate();
        return redirect()->intended(route('dashboard', absolute: false));
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
