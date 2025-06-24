<?php

namespace App\Http\Requests\Auth;

use App\Models\VerificationCode;
use App\Mail\VerificationCode as VerificationCodeMail;
use App\Rules\Recaptcha;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'email' => ['required', 'string', 'email', 'min:8', 'max:254'],
            'password' => ['required', 'string', 'min:8', 'max:254'],
            'cf-turnstile-response' => ['required', 'string']
        ];

        // Si hay un código en la sesión, requerir el código de verificación
        if (session()->has('pending_2fa_email')) {
            $rules['verification_code'] = ['required', 'string', 'size:6'];
        }

        return $rules;
    }

    /**
     * Get the custom validation messages for the request.
     *
     * To display these messages in a Blade template, you can use the `@error` directive.
     * For example, to show the error for the 'email' field:
     *
     * @error('email')
     *     <span class="text-danger">{{ $message }}</span>
     * @enderror
     */
    public function messages(): array
    {
        return [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.string' => 'El correo electrónico debe ser una cadena de texto.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'email.min' => 'El correo electrónico debe tener al menos 10 caracteres.',
            'email.max' => 'El correo electrónico no debe exceder los 100 caracteres.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.max' => 'La contraseña no debe exceder los 30 caracteres.',
            'cf-turnstile-response.required' => 'La verificación de Turnstile es obligatoria.',
            'verification_code.required' => 'El código de verificación es obligatorio.',
            'verification_code.size' => 'El código de verificación debe tener 6 dígitos.',
            'auth.failed' => 'Las credenciales proporcionadas son incorrectas.',
            'auth.throttle' => 'Demasiados intentos de inicio de sesión. Por favor, inténtalo de nuevo en :seconds segundos.',
            'verification_code.invalid' => 'El código de verificación es inválido o ya ha sido utilizado.',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Si hay un 2FA pendiente, verificar el código
        if (session()->has('pending_2fa_email')) {
            $this->verify2FA();
            return;
        }

        // Verificar credenciales
        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => $this->messages()['auth.failed'],
            ]);
        }

        // Si las credenciales son correctas, enviar código 2FA
        $this->send2FACode();
    }

    /**
     * Send 2FA code to user's email
     */
    protected function send2FACode(): void
    {
        Auth::logout(); // Cerrar sesión temporal

        $email = $this->input('email');
        $code = VerificationCode::generateCode($email);

        Mail::to($email)->send(new VerificationCodeMail($code, $email));

        session(['pending_2fa_email' => $email]);

        throw ValidationException::withMessages([
            'email' => 'Se ha enviado un código de verificación a tu correo electrónico.',
        ]);
    }

    /**
     * Verify 2FA code
     */
    protected function verify2FA(): void
    {
        $email = session('pending_2fa_email');
        $code = $this->input('verification_code');

        if (!VerificationCode::verify($email, $code)) {
            throw ValidationException::withMessages([
                'verification_code' => $this->messages()['verification_code.invalid'],
            ]);
        }

        // Código válido, autenticar al usuario
        if (! Auth::attempt(['email' => $email, 'password' => $this->input('password')], $this->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => $this->messages()['auth.failed'],
            ]);
        }

        // Limpiar sesión 2FA
        session()->forget('pending_2fa_email');
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 3)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages(messages: [
            'email' => str_replace(':seconds', $seconds, $this->messages()['auth.throttle']),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }
}
