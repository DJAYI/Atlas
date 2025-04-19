<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;

class DashboardSparks extends Component
{
    public $events;
    public $lastYearEventsCounts;
    public $lastYearAssistancesCounts;
    public $lastYearCareersCounts;

    public $totalEvents;
    public $totalAssistances;
    public $totalCareers;

    public function getLastYearEventsCounts()
    {
        $months = 12;
        $counts = array_fill(0, $months, 0);

        foreach ($this->events as $event) {
            $monthDiff = now()->diffInMonths($event->created_at, false);
            if ($monthDiff >= -11 && $monthDiff <= 0) {
                $counts[11 + $monthDiff]++;
            }
        }

        $this->totalEvents = array_sum($counts);

        return $counts;
    }

    public function getLastYearAssistancesCounts()
    {
        $months = 12;
        $counts = array_fill(0, $months, 0);

        foreach ($this->events as $event) {
            $monthDiff = now()->diffInMonths($event->created_at, false);
            if ($monthDiff >= -11 && $monthDiff <= 0) {
                $assistancesCount = $event->assistances->count();
                $counts[11 + $monthDiff] += $assistancesCount;
            }
        }

        $this->totalAssistances = array_sum($counts);

        return $counts;
    }

    public function getLastYearCareersCounts()
    {
        $months = 12;
        $counts = array_fill(0, $months, 0);

        foreach ($this->events as $event) {
            $monthDiff = now()->diffInMonths($event->created_at, false);
            if ($monthDiff >= -11 && $monthDiff <= 0) {
                $careersCount = $event->assistances
                    ->pluck('person.career')
                    ->unique()
                    ->count();
                $counts[11 + $monthDiff] += $careersCount;
            }
        }
        $this->totalCareers = array_sum($counts);

        return $counts;
    }

    public function mount()
    {
        $this->events = Event::all();
        $this->lastYearEventsCounts = $this->getLastYearEventsCounts();
        $this->lastYearAssistancesCounts = $this->getLastYearAssistancesCounts();
        $this->lastYearCareersCounts = $this->getLastYearCareersCounts();
    }

    public function render()
    {
        return view('livewire.dashboard-sparks');
    }
}
