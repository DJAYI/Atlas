<?php

namespace App\Providers;

use App\Models\Activity;
use App\Models\Agreement;
use App\Models\University;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class EventManagementServiceProvider extends ServiceProvider
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
        $activities = Activity::all();
        $universities = University::all();
        $agreements = Agreement::all();

        // Share data with create event modal component
        View::composer('components.modals.create-event-modal', function ($view) use ($activities, $universities, $agreements) {
            $view->with(compact('activities', 'universities', 'agreements'));
        });
    }
}
