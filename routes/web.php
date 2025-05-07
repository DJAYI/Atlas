<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AgreementController;
use App\Http\Controllers\AssistanceController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MapDataController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UniversityController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/es', 301);
Route::redirect('/login', '/', 301);

Route::group(['prefix' => '{locale}', 'where' => ['locale' => 'es|en']], function () {
    Route::get('/', function (string $locale) {
        if (Auth::check()) {
            return redirect(route('events'));
        }
        App::setLocale($locale);
        return view('index', ['locale' => $locale]);
    })->name('home');


    Route::get('/assistance', function (string $locale) {
        App::setLocale($locale);

        return (new AssistanceController())->index($locale);
    })->name('assistance');
});

Route::post('/{locale}/assistance', [AssistanceController::class, 'store'])->where('locale', 'es|en')->name('assistance.store');
Route::post('/{locale}/assistance/verify', [AssistanceController::class, 'verifyAssistance'])->where('locale', 'es|en')->name('assistance.verify');


// Rutes for the dashboard
Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return view('dashboard.index');
    })->name('dashboard')->middleware('role:admin');

    Route::prefix('regen')->group(function () {
        Route::get('/', function () {
            return redirect()->route('events');
        })->name('dashboard.regen');

        Route::get('/signatures', function () {
            return view('dashboard.pages.regen.signatures.index');
        })->name('dashboard.regen.signatures');
        Route::post('/signatures', [CertificateController::class, 'store'])->name('dashboard.regen.signatures.store');
    })->middleware('role:regen');

    Route::prefix('events')->group(function () {

        Route::get('/', [EventController::class, 'index'])->name('events');
        Route::post('/generate-report', [ReportController::class, 'generateReport'])->name('generate.report')->middleware('role:admin');
        Route::get('/edit/{id}', [EventController::class, 'edit'])->name('events.edit');

        Route::post('/', [EventController::class, 'store'])->name('events.store')->middleware('role:admin');
        Route::put('/{id}', [EventController::class, 'update'])->name('events.update')->middleware('role:admin');
        Route::delete('/{id}', [EventController::class, 'destroy'])->name('events.destroy')->middleware('role:admin');
        Route::post('/events/{id}/certificates', [CertificateController::class, 'sendAllCertificates'])->name('events.sendAllCertificates')->middleware('role:admin');

        Route::post('/events/{event_id}/certificates/{assistance_id}', [CertificateController::class, 'sendCertificate'])->name('events.sendCertificate')->middleware('role:admin');

        Route::post('/events/{event_id}/certificates/aprove', [CertificateController::class, 'approveCertificate'])->name('events.approveCertificate')->middleware('role:regen');
    });

    Route::prefix('universities')->group(function () {
        Route::get('/', [UniversityController::class, 'index'])->name('universities')->middleware('role:admin');
        Route::get('/{id}', [UniversityController::class, 'edit'])->name('universities.edit')->middleware('role:admin');
        Route::post('/', [UniversityController::class, 'store'])->name('universities.store')->middleware('role:admin');
        Route::put('/{id}', [UniversityController::class, 'update'])->name('universities.update')->middleware('role:admin');
        Route::delete('/{id}', [UniversityController::class, 'destroy'])->name('universities.destroy')->middleware('role:admin');
    });

    Route::prefix('activities')->group(function () {
        Route::get('/', [ActivityController::class, 'index'])->name('activities')->middleware('role:admin');
        Route::get('/{id}', [ActivityController::class, 'edit'])->name('activities.edit')->middleware('role:admin');
        Route::post('/', [ActivityController::class, 'store'])->name('activities.store')->middleware('role:admin');
        Route::put('/{id}', [ActivityController::class, 'update'])->name('activities.update')->middleware('role:admin');
        Route::delete('/{id}', [ActivityController::class, 'destroy'])->name('activities.destroy')->middleware('role:admin');
    })->middleware('role:admin');

    Route::prefix('agreements')->group(function () {
        Route::get('/', [AgreementController::class, 'index'])->name('agreements')->middleware('role:admin');
        Route::get('/{id}', [AgreementController::class, 'show'])->name('agreements.show')->middleware('role:admin');
        Route::post('/', [AgreementController::class, 'store'])->name('agreements.store')->middleware('role:admin');
        Route::put('/{id}', [AgreementController::class, 'update'])->name('agreements.update')->middleware('role:admin');
        Route::get('/{id}', [AgreementController::class, 'edit'])->name('agreements.edit')->middleware('role:admin');
        Route::delete('/{id}', [AgreementController::class, 'destroy'])->name('agreements.destroy')->middleware('role:admin');
    })->middleware('role:admin');

    Route::prefix('careers')->group(function () {
        Route::get('/', [CareerController::class, 'index'])->name('careers')->middleware('role:admin');
        Route::get('/{id}', [CareerController::class, 'edit'])->name('careers.edit')->middleware('role:admin');
        Route::post('/', [CareerController::class, 'store'])->name('careers.store')->middleware('role:admin');
        Route::put('/{id}', [CareerController::class, 'update'])->name('careers.update')->middleware('role:admin');
        Route::delete('/{id}', [CareerController::class, 'destroy'])->name('careers.destroy')->middleware('role:admin');
    })->middleware('role:admin');
});

require __DIR__ . '/auth.php';
