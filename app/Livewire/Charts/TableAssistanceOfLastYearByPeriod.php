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
            'Internacional Presencial' => [],
            'Nacional Presencial' => [],
            'Internacional Virtual' => [],
            'Nacional Virtual' => [],
            'total' => [],
        ];

        foreach ($periods as $period) {
            $periodKey = $period['key'];
            $periodos[] = $periodKey;

            // Inicializar contadores
            foreach (array_keys($data) as $key) {
                $data[$key][$periodKey] = 0;
            }

            // Contar asistencias por periodo y modalidad
            $data['Internacional Presencial'][$periodKey] = \App\Models\Assistance::whereHas('event', function ($q) use ($period) {
                $q->where('location', 'internacional')
                    ->where('modality', 'presencial')
                    ->whereBetween('created_at', [$period['start'], $period['end']]);
            })->count();

            $data['Nacional Presencial'][$periodKey] = \App\Models\Assistance::whereHas('event', function ($q) use ($period) {
                $q->whereIn('location', ['nacional', 'local'])
                    ->where('modality', 'presencial')
                    ->whereBetween('created_at', [$period['start'], $period['end']]);
            })->count();

            $data['Internacional Virtual'][$periodKey] = \App\Models\Assistance::whereHas('event', function ($q) use ($period) {
                $q->where('location', 'internacional')
                    ->where('modality', 'virtual')
                    ->whereBetween('created_at', [$period['start'], $period['end']]);
            })->count();

            $data['Nacional Virtual'][$periodKey] = \App\Models\Assistance::whereHas('event', function ($q) use ($period) {
                $q->whereIn('location', ['nacional', 'local'])
                    ->where('modality', 'virtual')
                    ->whereBetween('created_at', [$period['start'], $period['end']]);
            })->count();

            $data['total'][$periodKey] = $data['Internacional Presencial'][$periodKey]
                + $data['Nacional Presencial'][$periodKey]
                + $data['Internacional Virtual'][$periodKey]
                + $data['Nacional Virtual'][$periodKey];
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
            $data['Internacional Presencial'][$periodKey] += $count;
        }
        if ($event->location === 'nacional' && $event->modality === 'presencial') {
            $data['Nacional Presencial'][$periodKey] += $count;
        }
        if ($event->location === 'internacional' && $event->modality === 'virtual') {
            $data['Internacional Virtual'][$periodKey] += $count;
        }
        if ($event->location === 'nacional' && $event->modality === 'virtual') {
            $data['Nacional Virtual'][$periodKey] += $count;
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
