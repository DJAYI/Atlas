<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Validate session
    if (session()->has('user')) {
        return redirect()->route('dashboard');
    }

    return view('index');
})->name('index');

Route::middleware(['auth'])->group(
    function () {
        Route::get('/dashboard', function () {
            // Validate session
            if (!session()->has('user')) {
                return redirect()->route('index');
            }

            return view('dashboard.index');
        })->name('dashboard');
    }
);
