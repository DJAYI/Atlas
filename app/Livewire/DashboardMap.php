<?php

namespace App\Livewire;

use App\Http\Controllers\MapDataController;
use App\Models\Assistance;
use App\Models\University;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class DashboardMap extends Component
{
    public $lat;
    public $lng;
    public $cords = [];

    public function mount()
    {
        // Cachear datos del mapa por 10 minutos
        $this->cords = Cache::remember('dashboard_map_coordinates', 600, function () {
            return $this->getMapCoordinates();
        });
    }
    
    protected function getMapCoordinates()
    {
        // Solo universidades con coordenadas válidas y asistentes en el último año
        $universities = University::whereNotNull('lat')->whereNotNull('lng')->get();
        $eventIds = \App\Models\Event::all()->pluck('id');
        return $universities->map(function ($university) use ($eventIds) {
            $total = Assistance::whereHas('person', function ($query) use ($university) {
                $query->where('university_id', $university->id);
            })
                ->whereIn('event_id', $eventIds)
                ->count();
            $country = $university->country ? $university->country->name : null;
            return [
                'lat' => $university->lat,
                'lng' => $university->lng,
                'university_name' => $university->name,
                'university_total' => $total,
                'country' => $country,
            ];
        })->filter(fn($cord) => $cord['university_total'] > 0)->values()->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard-map');
    }
}
