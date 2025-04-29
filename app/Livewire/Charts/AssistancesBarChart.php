<?php

namespace App\Livewire\Charts;

use App\Models\Event;
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
            // Eager load assistances and their related person data
            $events = Event::whereYear('created_at', $year)
                ->with(['assistances.person.university'])
                ->get();

            $yearData = [
                'internacional' => [
                    'estudiante' => [ // Updated to use $this->movility
                        'virtual' => [
                            'entrantes' => 0,
                            'salientes' => 0,
                        ],
                        'presencial' => [
                            'entrantes' => 0,
                            'salientes' => 0,
                        ],
                    ],

                    'profesor' => [ // Updated to use $this->movility
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
                    'estudiante' => [ // Fixed typo to use $this->movility
                        'virtual' => [
                            'entrantes' => 0,
                            'salientes' => 0,
                        ],
                        'presencial' => [
                            'entrantes' => 0,
                            'salientes' => 0,
                        ],
                    ],
                    'profesor' => [ // Updated to use $this->movility
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

                'local' => [
                    'estudiante' => [ // Fixed typo to use $this->movility
                        'virtual' => [
                            'entrantes' => 0,
                            'salientes' => 0,
                        ],
                        'presencial' => [
                            'entrantes' => 0,
                            'salientes' => 0,
                        ],
                    ],
                    'profesor' => [ // Updated to use $this->movility
                        'virtual' => [
                            'entrantes' => 0,
                            'salientes' => 0,
                        ],
                        'presencial' => [
                            'entrantes' => 0,
                            'salientes' => 0,
                        ],
                    ],
                ],
            ];


            foreach ($events as $event) {
                foreach ($event->assistances as $assistance) {
                    $person = $assistance->person;

                    // Determine modality (presencial or virtual)
                    $modality = $event->modality; // 'presencial' or 'virtual'

                    // Determine person type (estudiante or profesor)
                    $personType = $person->type; // 'estudiante' or 'profesor'

                    // Determine location (local, nacional, or internacional)
                    $location = $event->location; // 'local', 'nacional', or 'internacional'

                    // Increment the count based on modality, person type, and location
                    if ($personType === 'estudiante' || $personType === 'profesor') {
                        if ($person->university->name !== 'FUNDACIÓN UNIVERSITARIA TECNOLÓGICO COMFENALCO') {
                            $yearData[$location][$personType][$modality]['entrantes']++;
                        } else {
                            $yearData[$location][$personType][$modality]['salientes']++;
                        }
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
