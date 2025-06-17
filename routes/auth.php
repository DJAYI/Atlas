<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login');
    Route::get('login', function () {
        return redirect()->route('home', ['locale' => app()->getLocale()]);
    });
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
