<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/assistance', function () {
    return view('assistance');
})->name('assistance');

Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::get('/events', [EventController::class, 'index'])->name('events');

    Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');

    Route::get('/events/edit/{id}', [EventController::class, 'edit'])->name('events.edit');

    Route::post('/events', [EventController::class, 'store'])->name('events.store');

    Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');

    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');
});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
