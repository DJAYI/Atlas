<?php

namespace App\Providers;

use App\Models\Faculty;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class CareerManagementServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('faculties')) {
            $faculty = Faculty::all();
            View::composer('components.modals.create-career-modal', function ($view) use ($faculty) {
                $view->with('faculties', $faculty);
            });
        }
    }
}
