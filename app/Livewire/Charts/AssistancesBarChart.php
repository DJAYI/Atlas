<?php

namespace App\Livewire\Charts;

use App\Models\Event;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class AssistancesBarChart extends Component
{
    public $statistics = [];

    public function getStatistics()
    {
        $currentYear = now()->year;
        $years = [$currentYear - 2, $currentYear - 1, $currentYear];

        $statistics = [];

        foreach ($years as $year) {
            $events = Cache::remember("events_for_year_{$year}", 3600, function () use ($year) {
                return Event::whereYear('start_date', $year)
                    ->with(['assistances.person.university', 'assistances.mobility'])
                    ->get();
            });

            $yearData = [
                'internacional' => [
                    'estudiante' => [
                        'virtual' => ['entrantes' => 0, 'salientes' => 0],
                        'presencial' => ['entrantes' => 0, 'salientes' => 0],
                    ],
                    'profesor' => [
                        'virtual' => ['entrantes' => 0, 'salientes' => 0],
                        'presencial' => ['entrantes' => 0, 'salientes' => 0],
                    ],
                    'egresado' => [
                        'virtual' => ['entrantes' => 0, 'salientes' => 0],
                        'presencial' => ['entrantes' => 0, 'salientes' => 0],
                    ],
                    'administrativo' => [
                        'virtual' => ['entrantes' => 0, 'salientes' => 0],
                        'presencial' => ['entrantes' => 0, 'salientes' => 0],
                    ],
                ],
                'nacional' => [
                    'estudiante' => [
                        'virtual' => ['entrantes' => 0, 'salientes' => 0],
                        'presencial' => ['entrantes' => 0, 'salientes' => 0],
                    ],
                    'profesor' => [
                        'virtual' => ['entrantes' => 0, 'salientes' => 0],
                        'presencial' => ['entrantes' => 0, 'salientes' => 0],
                    ],
                    'egresado' => [
                        'virtual' => ['entrantes' => 0, 'salientes' => 0],
                        'presencial' => ['entrantes' => 0, 'salientes' => 0],
                    ],
                    'administrativo' => [
                        'virtual' => ['entrantes' => 0, 'salientes' => 0],
                        'presencial' => ['entrantes' => 0, 'salientes' => 0],
                    ],
                ],
                'local' => [
                    'estudiante' => [
                        'virtual' => ['entrantes' => 0, 'salientes' => 0],
                        'presencial' => ['entrantes' => 0, 'salientes' => 0],
                    ],
                    'profesor' => [
                        'virtual' => ['entrantes' => 0, 'salientes' => 0],
                        'presencial' => ['entrantes' => 0, 'salientes' => 0],
                    ],
                    'egresado' => [
                        'virtual' => ['entrantes' => 0, 'salientes' => 0],
                        'presencial' => ['entrantes' => 0, 'salientes' => 0],
                    ],
                    'administrativo' => [
                        'virtual' => ['entrantes' => 0, 'salientes' => 0],
                        'presencial' => ['entrantes' => 0, 'salientes' => 0],
                    ],
                ],
            ];

            foreach ($events as $event) {
                foreach ($event->assistances as $assistance) {
                    $person = $assistance->person;
                    $mobilityType = $assistance->mobility->type ?? $person->type; // fallback por compatibilidad
                    $modality = $event->modality;
                    $location = $event->location;
                    if (isset($yearData[$location][$mobilityType][$modality])) {
                        $isEntrante = $person->university->name !== 'FUNDACIÓN UNIVERSITARIA TECNOLÓGICO COMFENALCO';
                        $key = $isEntrante ? 'entrantes' : 'salientes';
                        $yearData[$location][$mobilityType][$modality][$key]++;
                    }
                }
            }
            $statistics[$year] = $yearData;
        }

        $this->statistics = $statistics;
        return $this->statistics;
    }



    public function mount()
    {
        $this->getStatistics();
    }

    public function render()
    {
        return view('livewire.charts.assistances-bar-chart');
    }
}
