<?php

namespace App\Livewire\Charts;

use App\Models\Assistance;
use Livewire\Component;

class MobilityPieChart extends Component
{
    public $statistics = [
        "entrantes" => 0,
        "salientes" => 0,
        "en_casa" => 0,
    ];

    public function getStatistics()
    {
        // 1. Get all Events

        $events = \App\Models\Event::all();

        // 2. foreach event in the last year, get the assistances
        $lastYearAssistances = Assistance::whereIn('event_id', $events->pluck('id'))
            ->where('created_at', '>=', now()->subYear())
            ->get();

        // If there are no assistances, return 0 for all statistics
        if ($lastYearAssistances->isEmpty()) {
            $this->statistics = [
                "entrantes" => 0,
                "salientes" => 0,
                "en_casa" => 0,
            ];
            return;
        }

        $this->statistics = $lastYearAssistances->reduce(function ($carry, $assistance) {
            $universityId = $assistance->person->university_id;

            if ($universityId != 1) {
                $carry['entrantes'] += 1;
            } else {
                if ($assistance->event->internationalization_at_home === 'si') {
                    $carry['en_casa'] += 1;
                } else {
                    $carry['salientes'] += 1;
                }
            }



            return $carry;
        }, [
            "entrantes" => 0,
            "salientes" => 0,
            "en_casa" => 0,
        ]);
    }

    public function mount()
    {
        $this->getStatistics();
    }

    public function render()
    {
        return view('livewire.charts.mobility-pie-chart');
    }
}
