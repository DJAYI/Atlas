<?php

namespace App\Livewire\Charts;

use Livewire\Component;

class MobilityPieChart extends Component
{
    public $statistics = [
        "entrantes" => 0,
        "salientes" => 0,
        "en_casa" => 0,
    ];

    public function mount($statistics = [])
    {
        if (!empty($statistics)) {
            $this->statistics = $statistics;
        }
    }

    public function render()
    {
        return view('livewire.charts.mobility-pie-chart');
    }
}
