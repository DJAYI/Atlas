<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class Recaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = Http::asForm()->post("https://www.google.com/recaptcha/api/siteverify", [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $value,
            'ip' => request()->ip(),
        ]);

        if ($response->successful() && $response->json('success') && $response->json('score') > config('services.recaptcha.min_score')) {
            $fail("{$attribute} is valid.");
            return;
        }

        $fail("The {$attribute} is invalid.");
    }
}
