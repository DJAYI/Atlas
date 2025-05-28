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
        // Obtener el id real de Comfenalco
        $comfenalco = \App\Models\University::where('name', 'FUNDACIÓN UNIVERSITARIA TECNOLÓGICO COMFENALCO')->first();
        $comfenalcoId = $comfenalco ? $comfenalco->id : null;

        // Solo asistencias de eventos del último año (por start_date)
        $eventIds = \App\Models\Event::where('start_date', '>=', now()->subYear())->pluck('id');
        $lastYearAssistances = Assistance::whereIn('event_id', $eventIds)->get();

        if ($lastYearAssistances->isEmpty() || !$comfenalcoId) {
            $this->statistics = [
                "entrantes" => 0,
                "salientes" => 0,
                "en_casa" => 0,
            ];
            return;
        }

        $this->statistics = $lastYearAssistances->reduce(function ($carry, $assistance) use ($comfenalcoId) {
            $universityId = $assistance->person->university_id;

            if ($universityId != $comfenalcoId) {
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
