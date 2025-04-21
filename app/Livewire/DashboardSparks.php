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

    public function getCounts($type, $months = 10, $indexOffset = 9)
    {
        $counts = array_fill(0, $months, 0);

        foreach ($this->events as $event) {
            $monthDiff = now()->diffInMonths($event->created_at, false);
            if ($monthDiff >= -$indexOffset && $monthDiff <= 0) {
                $count = match ($type) {
                    'events' => 1,
                    'assistances' => $event->assistances->count(),
                    'careers' => $event->assistances
                        ->pluck('person.career')
                        ->unique()
                        ->count(),
                    default => 0,
                };
                $counts[$indexOffset + $monthDiff] += $count;
            }
        }

        return $counts;
    }

    public function getLastYearEventsCounts()
    {
        $counts = $this->getCounts('events', 10, 10);
        $this->totalEvents = array_sum($counts);

        return $counts;
    }

    public function getLastYearAssistancesCounts()
    {
        $counts = $this->getCounts('assistances', 10, 10);
        $this->totalAssistances = array_sum($counts);

        return $counts;
    }

    public function getLastYearCareersCounts()
    {
        $counts = $this->getCounts('careers', 10, 10);
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
