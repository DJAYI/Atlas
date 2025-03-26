<?php

namespace App\Providers;

use App\Models\City;
use App\Models\Country;
use Illuminate\Support\Facades\Schema;
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


        if (Schema::hasTable('countries')) {
            $countries = Country::all();

            View::composer('components.modals.create-university-modal', function ($view) use ($countries) {
                $view->with(compact('countries'));
            });
        }
    }
}
