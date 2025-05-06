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
        $periods = $this->getLastThreeSemesters($currentDate);

        $periodos = [];
        $data = [
            'Entrante Internacional Presencial' => [],
            'Entrante Nacional Presencial' => [],
            'Entrante Internacional Virtual' => [],
            'Entrante Nacional Virtual' => [],
            'total' => [],
        ];

        foreach ($periods as $period) {
            $periodKey = $period['key'];
            $periodos[] = $periodKey;

            // Inicializar contadores
            foreach (array_keys($data) as $key) {
                $data[$key][$periodKey] = 0;
            }

            // Consultar eventos del periodo
            $events = Event::whereBetween('created_at', [$period['start'], $period['end']])->get();

            foreach ($events as $event) {
                if ($event->university_id == 1) {
                    continue;
                }
                $count = $event->assistances()->count();

                $this->addAssistanceCount($data, $event, $periodKey, $count);
            }

            // Calcular total por periodo
            $data['total'][$periodKey] =
                $data['Entrante Internacional Presencial'][$periodKey] +
                $data['Entrante Nacional Presencial'][$periodKey] +
                $data['Entrante Internacional Virtual'][$periodKey] +
                $data['Entrante Nacional Virtual'][$periodKey];
        }

        $this->statistics = [
            'periodos' => $periodos,
            'data' => $data,
        ];

        return $this->statistics;
    }

    private function getLastThreeSemesters($currentDate)
    {
        $periods = [];
        for ($i = 2; $i >= 0; $i--) {
            $date = $currentDate->copy()->subMonths($i * 6);
            $year = $date->format('Y');
            $month = (int)$date->format('n');
            if ($month >= 7) {
                $key = $year . '-2';
                $start = $date->copy()->startOfYear()->addMonths(6)->startOfMonth()->toDateString(); // Jul 1
                $end = $date->copy()->endOfYear()->toDateString(); // Dec 31
            } else {
                $key = $year . '-1';
                $start = $date->copy()->startOfYear()->toDateString(); // Jan 1
                $end = $date->copy()->startOfYear()->addMonths(5)->endOfMonth()->toDateString(); // Jun 30
            }
            $periods[] = [
                'key' => $key,
                'start' => $start,
                'end' => $end,
            ];
        }
        usort($periods, function ($a, $b) {
            return strcmp($a['start'], $b['start']);
        });
        return $periods;
    }

    private function addAssistanceCount(&$data, $event, $periodKey, $count)
    {
        if ($event->location === 'internacional' && $event->modality === 'presencial') {
            $data['Entrante Internacional Presencial'][$periodKey] += $count;
        }
        if ($event->location === 'nacional' && $event->modality === 'presencial') {
            $data['Entrante Nacional Presencial'][$periodKey] += $count;
        }
        if ($event->location === 'internacional' && $event->modality === 'virtual') {
            $data['Entrante Internacional Virtual'][$periodKey] += $count;
        }
        if ($event->location === 'nacional' && $event->modality === 'virtual') {
            $data['Entrante Nacional Virtual'][$periodKey] += $count;
        }
    }

    public function mount()
    {
        $this->getStatistics();
    }

    public function render()
    {
        return view('livewire.charts.table-assistance-of-last-year-by-period', [
            'statistics' => $this->statistics,
        ]);
    }
}
