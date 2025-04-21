<?php

namespace App\Livewire;

use App\Http\Controllers\MapDataController;
use App\Models\Assistance;
use App\Models\University;
use Livewire\Component;

class DashboardMap extends Component
{
    public $lat;
    public $lng;
    public $cords = [];

    public function mount()
    {
        $universities = University::all();
        $this->cords = $universities->map(function ($university) {
            return [
                'lat' => $university->lat,
                'lng' => $university->lng,
                'university_name' => $university->name,
                'university_total' => Assistance::whereHas('person', function ($query) use ($university) {
                    $query->where('university_id', $university->id);
                })->count(),
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard-map');
    }
}
