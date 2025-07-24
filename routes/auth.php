<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\TwoFactorController;

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login');
    Route::get('login', function () {
        return redirect()->route('home', ['locale' => app()->getLocale()]);
    });
});

// Two-Factor Authentication routes with custom middleware
Route::middleware('2fa')->group(function () {
    Route::get('2fa/verify', [TwoFactorController::class, 'show'])->name('2fa.show');
    Route::post('2fa/verify', [TwoFactorController::class, 'verify'])->name('2fa.verify');
    Route::get('2fa/resend', [TwoFactorController::class, 'resend'])->name('2fa.resend');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
