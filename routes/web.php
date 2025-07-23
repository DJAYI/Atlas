<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AgreementController;
use App\Http\Controllers\AssistanceController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

// Redirección explícita para la raíz de public que respeta el subdirectorio
Route::get('/', function () {
    return redirect()->to(request()->getBasePath() . '/es');
});

Route::group(['prefix' => '{locale}', 'where' => ['locale' => 'es|en']], function () {
    Route::get('/', function (string $locale) {
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
// If the person does not exist, create it
// If the person exists, create the assistance
// If the assistance exists, use the existing one

// Rutes for the dashboard
Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return view('dashboard.index');
    })->middleware(['permission:access dashboard', 'redirect.auxiliar'])->name('dashboard');

    Route::prefix('events')->group(function () {
        Route::get('/', [EventController::class, 'index'])->middleware('permission:view events')->name('events');
        Route::post('/generate-report', [ReportController::class, 'generateReport'])->middleware('permission:generate reports')->name('generate.report');
        Route::post('/generate-certificate', [ReportController::class, 'generateTemplateCertificates'])->middleware('permission:generate reports')->name('generate.certificate');
        Route::get('/edit/{id}', [EventController::class, 'edit'])->middleware('permission:edit events|view events')->name('events.edit');
        Route::post('/', [EventController::class, 'store'])->middleware('permission:create events')->name('events.store');
        Route::put('/{id}', [EventController::class, 'update'])->middleware('permission:edit events')->name('events.update');
        Route::delete('/{id}', [EventController::class, 'destroy'])->middleware('permission:delete events')->name('events.destroy');
        Route::get('/{id}/photographic-support/download', [EventController::class, 'downloadPhotographicSupport'])->middleware('permission:view events')->name('events.downloadPhotographicSupport');
        Route::delete('/{eventId}/photographic-support/{fileIndex}', [EventController::class, 'removePhotographicSupportFile'])->middleware('permission:edit events')->name('events.removePhotographicSupportFile');
        Route::post('/events/{id}/surveys', [SurveyController::class, 'sendAllSurveys'])->middleware('permission:edit events')->name('events.sendAllSurveys');
        Route::post('/events/{event_id}/surveys/{assistance_id}', [SurveyController::class, 'sendSurvey'])->middleware('permission:edit events')->name('events.sendSurvey');
        Route::post('/events/{event_id}/assistances', [AssistanceController::class, 'exportAssistances'])->middleware('permission:view events')->name('events.exportAssistances');
        Route::post('/events/{event_id}/assistances/zip', [AssistanceController::class, 'exportIdentityDocumentsZip'])->middleware('permission:view events')->name('events.zipIdentityDocuments');
    });

    Route::prefix('universities')->group(function () {
        Route::get('/', [UniversityController::class, 'index'])->middleware('permission:view universities')->name('universities');
        Route::get('/{id}', [UniversityController::class, 'edit'])->middleware('permission:edit universities|view universities')->name('universities.edit');
        Route::post('/', [UniversityController::class, 'store'])->middleware('permission:create universities')->name('universities.store');
        Route::put('/{id}', [UniversityController::class, 'update'])->middleware('permission:edit universities')->name('universities.update');
        Route::delete('/{id}', [UniversityController::class, 'destroy'])->middleware('permission:delete universities')->name('universities.destroy');
    });

    Route::prefix('activities')->group(function () {
        Route::get('/', [ActivityController::class, 'index'])->middleware('permission:view activities')->name('activities');
        Route::get('/{id}', [ActivityController::class, 'edit'])->middleware('permission:edit activities|view activities')->name('activities.edit');
        Route::post('/', [ActivityController::class, 'store'])->middleware('permission:create activities')->name('activities.store');
        Route::put('/{id}', [ActivityController::class, 'update'])->middleware('permission:edit activities')->name('activities.update');
        Route::delete('/{id}', [ActivityController::class, 'destroy'])->middleware('permission:delete activities')->name('activities.destroy');
    });

    Route::prefix('agreements')->group(function () {
        Route::get('/', [AgreementController::class, 'index'])->middleware('permission:view agreements')->name('agreements');
        Route::get('/{id}', [AgreementController::class, 'show'])->middleware('permission:view agreements')->name('agreements.show');
        Route::post('/', [AgreementController::class, 'store'])->middleware('permission:create agreements')->name('agreements.store');
        Route::put('/{id}', [AgreementController::class, 'update'])->middleware('permission:edit agreements')->name('agreements.update');
        Route::get('/{id}', [AgreementController::class, 'edit'])->middleware('permission:edit agreements|view agreements')->name('agreements.edit');
        Route::delete('/{id}', [AgreementController::class, 'destroy'])->middleware('permission:delete agreements')->name('agreements.destroy');
    });

    Route::prefix('careers')->group(function () {
        Route::get('/', [CareerController::class, 'index'])->middleware('permission:view programs')->name('careers');
        Route::get('/{id}', [CareerController::class, 'edit'])->middleware('permission:edit programs|view programs')->name('careers.edit');
        Route::post('/', [CareerController::class, 'store'])->middleware('permission:create programs')->name('careers.store');
        Route::put('/{id}', [CareerController::class, 'update'])->middleware('permission:edit programs')->name('careers.update');
        Route::delete('/{id}', [CareerController::class, 'destroy'])->middleware('permission:delete programs')->name('careers.destroy');
    });
    
    // User management routes - only accessible by admin with manage users permission
    Route::prefix('users')->middleware('permission:manage users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users');
        Route::get('/{id}', [UserController::class, 'edit'])->name('users.edit')->where('id', '[0-9]+');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});

require __DIR__ . '/auth.php';


Livewire::setScriptRoute(function ($handle) {
    return Route::get(request()->getBasePath() . '/livewire/livewire.js', $handle);
});

Livewire::setUpdateRoute(function ($handle) {
    return Route::post(request()->getBasePath() . '/livewire/update', $handle);
});
