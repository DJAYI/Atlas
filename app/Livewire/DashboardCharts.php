<?php

namespace App\Livewire;

use App\Models\Assistance;
use App\Models\Event;
use App\Models\University;
use Illuminate\Support\Collection;
use Livewire\Component;

class DashboardCharts extends Component
{
    public function getEventStatistics()
    {
        $currentYear = now()->year;
        $years = [$currentYear - 2, $currentYear - 1, $currentYear];

        $statistics = [];

        foreach ($years as $year) {
            // Eager load assistances and their related person data
            $events = Event::whereYear('created_at', $year)
                ->with(['assistances.person.university'])
                ->get();

            $yearData = [
                'internacional' => [
                    'estudiantes' => [
                        'virtual' => [
                            'entrantes' => 0,
                            'salientes' => 0,
                        ],
                        'presencial' => [
                            'entrantes' => 0,
                            'salientes' => 0,
                        ],
                    ]
                ],

                'nacional' => [
                    'estudiantes' => [
                        'virtual' => [
                            'entrantes' => 0,
                            'salientes' => 0,
                        ],
                        'presencial' => [
                            'entrantes' => 0,
                            'salientes' => 0,
                        ],
                    ]
                ],
            ];


            foreach ($events as $event) {
                foreach ($event->assistances as $assistance) {
                    $person = $assistance->person;

                    // Determinar modalidad (presencial o virtual)
                    $modality = $event->modality; // 'presencial' o 'virtual'

                    // Determinar tipo de persona (estudiante o profesor)
                    $personType = $person->type; // 'estudiantes' o 'profesores'

                    // Determinar ubicación (nacional o internacional)
                    $location = $event->location; // 'nacional' o 'internacional'

                    // Incrementar el conteo según modalidad, tipo de persona y ubicación

                    if ($personType === 'profesor') {
                        if ($person->university->name !== 'FUNDACIÓN UNIVERSITARIA TECNOLÓGICO COMFENALCO') {
                            $yearData[$location]['profesores'][$modality]['entrantes']++;
                        } else {
                            $yearData[$location]['profesores'][$modality]['salientes']++;
                        }
                    } elseif ($personType === 'estudiante') {
                        if ($person->university->name !== 'FUNDACIÓN UNIVERSITARIA TECNOLÓGICO COMFENALCO') {
                            $yearData[$location]['estudiantes'][$modality]['entrantes']++;
                        } else {
                            $yearData[$location]['estudiantes'][$modality]['salientes']++;
                        }
                    }
                }
            }

            $statistics[$year] = $yearData;
        }

        return $statistics;
    }

    public function render()
    {
        $statistics = $this->getEventStatistics();

        return view('livewire.dashboard-charts', compact('statistics'));
    }
}
