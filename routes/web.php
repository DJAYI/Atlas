<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AgreementController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UniversityController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/es', 301);


Route::group(['prefix' => '{locale}', 'where' => ['locale' => 'es|en']], function () {
    Route::get('/', function (string $locale) {
        App::setLocale($locale);
        return view('index', ['locale' => $locale]);
    })->name('home');

    Route::get('/assistance', function (string $locale) {
        App::setLocale($locale);
        return view('assistance', ['locale' => $locale]);
    })->name('assistance');
});


// Rutes for the dashboard
Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::prefix('events')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('events');
        Route::get('/edit/{id}', [EventController::class, 'edit'])->name('events.edit');
        Route::post('/', [EventController::class, 'store'])->name('events.store');
        Route::put('/{id}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/{id}', [EventController::class, 'destroy'])->name('events.destroy');
        Route::post('/events/{id}/certificates', [EventController::class, 'sendAllCertificates'])->name('events.sendAllCertificates');
        Route::post('/events/{id}/certificates/{id}', [EventController::class, 'sendCertificate'])->name('events.sendCertificate');
    });

    Route::prefix('universities')->group(function () {
        Route::get('/', [UniversityController::class, 'index'])->name('universities');
        Route::get('/{id}', [UniversityController::class, 'edit'])->name('universities.edit');
        Route::post('/', [UniversityController::class, 'store'])->name('universities.store');
        Route::put('/{id}', [UniversityController::class, 'update'])->name('universities.update');
        Route::delete('/{id}', [UniversityController::class, 'destroy'])->name('universities.destroy');
    });

    Route::prefix('activities')->group(function () {
        Route::get('/', [ActivityController::class, 'index'])->name('activities');
        Route::get('/{id}', [ActivityController::class, 'edit'])->name('activities.edit');
        Route::post('/', [ActivityController::class, 'store'])->name('activities.store');
        Route::put('/{id}', [ActivityController::class, 'update'])->name('activities.update');
        Route::delete('/{id}', [ActivityController::class, 'destroy'])->name('activities.destroy');
    });

    Route::prefix('agreements')->group(function () {
        Route::get('/', [AgreementController::class, 'index'])->name('agreements');
        Route::get('/{id}', [AgreementController::class, 'show'])->name('agreements.show');
        Route::post('/', [AgreementController::class, 'store'])->name('agreements.store');
        Route::put('/{id}', [AgreementController::class, 'update'])->name('agreements.update');
        Route::get('/{id}', [AgreementController::class, 'edit'])->name('agreements.edit');
        Route::delete('/{id}', [AgreementController::class, 'destroy'])->name('agreements.destroy');
    });

    Route::prefix('careers')->group(function () {
        Route::get('/', [CareerController::class, 'index'])->name('careers');
        Route::get('/{id}', [CareerController::class, 'edit'])->name('careers.edit');
        Route::post('/', [CareerController::class, 'store'])->name('careers.store');
        Route::put('/{id}', [CareerController::class, 'update'])->name('careers.update');
        Route::delete('/{id}', [CareerController::class, 'destroy'])->name('careers.destroy');
    });
});





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
