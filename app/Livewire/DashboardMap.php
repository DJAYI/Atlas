<?php

namespace App\Livewire;

use App\Http\Controllers\MapDataController;
use Livewire\Component;

class DashboardMap extends Component
{
    public $mapLocations;

    public function getMapLocations()
    {
        $mapDataController = new MapDataController();
        $data = $mapDataController->locations(); // ya es un array plano
        return $data['locations'];
    }

    public function mount()
    {
        $this->mapLocations = $this->getMapLocations();
    }

    public function render()
    {
        return view('livewire.dashboard-map');
    }
}
