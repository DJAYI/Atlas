<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VerificationCode extends Model
{
    protected $fillable = [
        'email',
        'code',
        'expires_at',
        'used',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean',
    ];

    public static function generateCode(string $email): string
    {
        // Limpiar códigos anteriores del mismo email
        self::where('email', $email)->delete();

        $code = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        self::create([
            'email' => $email,
            'code' => $code,
            'expires_at' => null, // Sin expiración por tiempo
        ]);

        return $code;
    }

    public static function verify(string $email, string $code): bool
    {
        $verificationCode = self::where('email', $email)
            ->where('code', $code)
            ->where('used', false)
            ->first(); // Removido el filtro de expires_at

        if ($verificationCode) {
            $verificationCode->update(['used' => true]);
            return true;
        }

        return false;
    }
}
