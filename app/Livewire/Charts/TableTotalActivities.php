<?php

namespace App\Livewire\Charts;

use Livewire\Component;

class TableTotalActivities extends Component
{
    public $activities = [];
    public $totalResults = [];

    public function mount($activities = [], $totalResults = [])
    {
        if (!empty($activities)) {
            $this->activities = $activities;
        }

        if (!empty($totalResults)) {
            $this->totalResults = $totalResults;
        }
    }

    public function render()
    {
        return view('livewire.charts.table-total-activities');
    }
}
