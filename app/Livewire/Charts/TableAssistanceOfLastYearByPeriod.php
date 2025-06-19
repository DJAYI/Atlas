<?php

namespace App\Livewire\Charts;

use Livewire\Component;

class TableAssistanceOfLastYearByPeriod extends Component
{
    public $statistics = [];
    public $periods = [];

    public function mount($statistics = [], $periods = [])
    {
        $this->statistics = $statistics;
        $this->periods = $periods;
    }

    public function render()
    {
        return view('livewire.charts.table-assistance-of-last-year-by-period');
    }
}
