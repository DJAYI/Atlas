<?php

namespace App\Providers;

use App\Models\Activity;
use App\Models\Agreement;
use App\Models\Career;
use App\Models\Event;
use App\Models\University;
use Illuminate\Support\Facades\Schema;
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
        if (
            Schema::hasTable('activities') &&
            Schema::hasTable('universities') &&
            Schema::hasTable('agreements') &&
            Schema::hasTable('careers')
        ) {

            $activities = Activity::all();
            $universities = University::all();
            $agreements = Agreement::all();
            $events = Event::all();
            $careers = Career::all();

            // Share data with create event modal component
            View::composer('components.modals.create-event-modal', function ($view) use ($activities, $universities, $agreements, $careers) {
                $view->with(compact('activities', 'universities', 'agreements', 'careers'));
            });

            View::composer('dashboard.index', function ($view) use ($events) {
                $view->with(compact('events'));
            });
        }
    }
}
