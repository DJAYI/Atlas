<?php

namespace App\Livewire\Charts;

use App\Models\Event;
use Livewire\Component;

class AssistancesBarChart extends Component
{
    public $movility = 'estudiante';
    public $statistics = [];

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
                    $this->movility => [ // Updated to use $this->movility
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
                    $this->movility => [ // Fixed typo to use $this->movility
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
                    $personType = $person->type; // $movility o 'profesores'

                    // Determinar ubicación (nacional o internacional)
                    $location = $event->location; // 'nacional' o 'internacional'

                    // Incrementar el conteo según modalidad, tipo de persona y ubicación

                    if ($personType === $this->movility) {
                        if ($person->university->name !== 'FUNDACIÓN UNIVERSITARIA TECNOLÓGICO COMFENALCO') {
                            $yearData[$location][$this->movility][$modality]['entrantes']++;
                        } else {
                            $yearData[$location][$this->movility][$modality]['salientes']++;
                        }
                    }
                }
            }

            $statistics[$year] = $yearData;
        }

        $this->statistics = $statistics;
        return $this->statistics;
    }

    public function handleMovilityChange($movility)
    {
        $this->movility = $movility;
    }

    public function handleUpdateEventStatistics()
    {
        $this->getEventStatistics();
    }

    public function mount()
    {
        $this->movility = 'estudiante';
        $this->getEventStatistics();
    }

    public function render()
    {
        return view('livewire.charts.assistances-bar-chart');
    }
}
