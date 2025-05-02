<?php

namespace App\Livewire\Charts;

use App\Models\Event;
use Livewire\Component;

class TableAssistanceOfLastYearByPeriod extends Component
{
    public $statistics = [];

    public function getStatistics()
    {
        $currentDate = now();
        $periods = [
            ['start' => $currentDate->copy()->subMonths(24)->startOfMonth()->toDateString(), 'end' => $currentDate->copy()->subMonths(13)->endOfMonth()->toDateString()],
            ['start' => $currentDate->copy()->subMonths(12)->startOfMonth()->toDateString(), 'end' => $currentDate->copy()->subMonths(7)->endOfMonth()->toDateString()],
            ['start' => $currentDate->copy()->subMonths(6)->startOfMonth()->toDateString(), 'end' => $currentDate->copy()->subMonths(1)->endOfMonth()->toDateString()],
        ];

        $statistics = [];

        foreach ($periods as $index => $period) {
            $periodKey = $period['start'] . ' - ' . $period['end'];

            // Eager load assistances and their related person data for the period
            $events = Event::whereBetween('created_at', [$period['start'], $period['end']])
                ->with(['assistances.person.university'])
                ->get();

            $statistics[$periodKey] = [
                'internacional' => [
                    'entrantes' => 0,
                    'salientes' => 0,
                ],

                'nacional' => [
                    'entrantes' => 0,
                    'salientes' => 0,
                ],
            ];

            foreach ($events as $event) {
                foreach ($event->assistances as $assistance) {
                    $person = $assistance->person;

                    // Increment the count based on modality, person type, and location
                    if ($event->location === 'internacional') {
                        if ($person->university->name !== 'FUNDACIÓN UNIVERSITARIA TECNOLÓGICO COMFENALCO') {
                            $statistics[$periodKey]['internacional']['entrantes']++;
                        } else {
                            $statistics[$periodKey]['internacional']['salientes']++;
                        }
                    } elseif ($event->location === 'nacional') {
                        if ($person->university->name !== 'FUNDACIÓN UNIVERSITARIA TECNOLÓGICO COMFENALCO') {
                            $statistics[$periodKey]['nacional']['entrantes']++;
                        } else {
                            $statistics[$periodKey]['nacional']['salientes']++;
                        }
                    }
                }
            }
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
        return view('livewire.charts.table-assistance-of-last-year-by-period');
    }
}
