<?php

namespace App\Livewire\Charts;

use Livewire\Component;

class AssistancesBarChart extends Component
{
    public $statistics = [];

    public function mount($statistics = [])
    {
        $this->statistics = $statistics;
    }

    public function render()
    {
        return view('livewire.charts.assistances-bar-chart');
    }
}
