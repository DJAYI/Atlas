<?php

namespace App\Providers;

use App\Models\City;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class UniversityManagementServiceProvider extends ServiceProvider
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
        $cities = City::all();

        View::composer('components.modals.create-university-modal', function ($view) use ($cities) {
            $view->with(compact('cities'));
        });
    }
}
