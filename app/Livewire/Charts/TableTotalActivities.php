<?php

namespace App\Livewire\Charts;

use App\Models\Activity;
use Livewire\Component;

class TableTotalActivities extends Component
{
    public $activities = [];
    public $totalResults = [];
    public function mount()
    {
        // Obtener todas las actividades
        $activities = Activity::all();

        // Agrupar actividades por nombre y contar asistentes y eventos
        $this->activities = $activities->map(function ($activity) {
            // 1. Cada evento tiene una actividad
            $events = $activity->events;
            // 2. Contar el número de asistentes por evento
            $totalAssistants = $events->sum(function ($event) {
                return $event->assistances->count();
            });
            // 3. Contar el número de eventos por actividad
            $totalActivities = $events->count();
            // 4. Formatear el resultado y obtener el total

            return [
                'name' => $activity->name,
                'total_assistants' => $totalAssistants,
                'total_activities' => $totalActivities,
            ];
        })->toArray();

        // Calcular el total de asistentes y actividades
        $this->totalResults = [
            'total_assistants' => collect($this->activities)->sum('total_assistants'),
            'total_activities' => collect($this->activities)->sum('total_activities'),
        ];
    }


    public function render()
    {
        return view('livewire.charts.table-total-activities');
    }
}
