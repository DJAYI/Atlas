<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;

class DashboardSparks extends Component
{
    public $events;
    public $lastYearEventsCounts;
    public $lastYearAssistancesCounts;
    public $lastYearCareersCounts;
    public $lastYearUniqueParticipantsCounts;

    public $totalEvents;
    public $totalAssistances;
    public $totalCareers;

    public $lastYearAssistancesPerMonth;
    public $lastYearEventsPerMonth;
    public $lastYearCareersPerMonth;
    public $lastYearUniqueParticipantsPerMonth;
    public $totalUniqueParticipants;

    public function getCounts($type, $months = 10, $indexOffset = 9)
    {
        $counts = array_fill(0, $months, 0);

        foreach ($this->events as $event) {
            $monthDiff = now()->diffInMonths($event->created_at, false);
            if ($monthDiff >= -$indexOffset && $monthDiff <= 0) {
                $count = match ($type) {
                    'events' => 1,
                    'assistances' => $event->assistances->count(),
                    'careers' => $event->assistances
                        ->pluck('person.career')
                        ->unique()
                        ->count(),
                    default => 0,
                };
                $counts[$indexOffset + $monthDiff] += $count;
            }
        }

        return $counts;
    }

    public function getLastYearEventsCounts()
    {
        $counts = $this->getCounts('events', 10, 10);
        $this->totalEvents = array_sum($counts);

        return $counts;
    }

    public function getLastYearAssistancesCounts()
    {
        $counts = $this->getCounts('assistances', 10, 10);
        $this->totalAssistances = array_sum($counts);

        return $counts;
    }

    public function getLastYearCareersCounts()
    {
        $counts = $this->getCounts('careers', 10, 10);
        $this->totalCareers = array_sum($counts);

        return $counts;
    }

    public function getLastYearUniqueParticipantsCounts()
    {
        // Obtener el rango de los últimos 12 meses
        $start = now()->copy()->subYear()->startOfMonth();
        $end = now()->copy()->endOfMonth();
        $months = [];
        $current = $start->copy();
        while ($current <= $end) {
            $months[$current->format('Y-m')] = 0;
            $current->addMonth();
        }
        // Consultar participantes únicos por mes
        $assistances = \App\Models\Assistance::whereHas('event', function ($q) use ($start, $end) {
            $q->whereBetween('start_date', [$start, $end]);
        })->get();
        $grouped = $assistances->groupBy(function ($a) {
            return optional($a->event->start_date)->format('Y-m');
        });
        foreach ($months as $month => $val) {
            if (isset($grouped[$month])) {
                $months[$month] = $grouped[$month]->pluck('person_id')->unique()->count();
            }
        }
        return array_values($months);
    }

    public function getLastYearEventsPerMonth()
    {
        $start = now()->copy()->subYear()->startOfMonth();
        $end = now()->copy()->endOfMonth();
        $months = [];
        $labels = [];
        $current = $start->copy();
        while ($current <= $end) {
            $key = $current->format('Y-m');
            $months[$key] = 0;
            $labels[] = $current->format('M Y');
            $current->addMonth();
        }
        $events = Event::whereBetween('start_date', [$start, $end])->get();
        $grouped = $events->groupBy(function ($e) {
            return optional($e->start_date)->format('Y-m');
        });
        foreach ($months as $month => $val) {
            if (isset($grouped[$month])) {
                $months[$month] = $grouped[$month]->count();
            }
        }
        return [
            'data' => array_values($months),
            'labels' => $labels
        ];
    }

    // Devuelve asistencias totales por mes en el último año
    public function getLastYearAssistancesPerMonth()
    {
        // Ajuste: rango exacto de 1 año hasta hoy (no fin de mes)
        $start = now()->copy()->subYear()->addDay(); // 1 año atrás, mismo día
        $end = now(); // hoy
        $months = [];
        $labels = [];
        $current = $start->copy()->startOfMonth();
        while ($current <= $end) {
            $key = $current->format('Y-m');
            $months[$key] = 0;
            $labels[] = $current->format('M Y');
            $current->addMonth();
        }
        $assistances = \App\Models\Assistance::whereHas('event', function ($q) use ($start, $end) {
            $q->whereBetween('start_date', [$start, $end]);
        })->get();
        $grouped = $assistances->groupBy(function ($a) {
            return optional($a->event->start_date)->format('Y-m');
        });
        foreach ($months as $month => $val) {
            if (isset($grouped[$month])) {
                $months[$month] = $grouped[$month]->count();
            }
        }
        return [
            'data' => array_values($months),
            'labels' => $labels
        ];
    }

    // Devuelve programas participantes únicos por mes en el último año
    public function getLastYearCareersPerMonth()
    {
        $start = now()->copy()->subYear()->startOfMonth();
        $end = now()->copy()->endOfMonth();
        $months = [];
        $labels = [];
        $current = $start->copy();
        while ($current <= $end) {
            $key = $current->format('Y-m');
            $months[$key] = 0;
            $labels[] = $current->format('M Y');
            $current->addMonth();
        }
        $assistances = \App\Models\Assistance::whereHas('event', function ($q) use ($start, $end) {
            $q->whereBetween('start_date', [$start, $end]);
        })->get();
        $grouped = $assistances->groupBy(function ($a) {
            return optional($a->event->start_date)->format('Y-m');
        });
        foreach ($months as $month => $val) {
            if (isset($grouped[$month])) {
                $months[$month] = $grouped[$month]->pluck('person.career_id')->unique()->count();
            }
        }
        return [
            'data' => array_values($months),
            'labels' => $labels
        ];
    }

    // Devuelve participantes únicos por mes y el total del año
    public function getLastYearUniqueParticipantsPerMonth()
    {
        $start = now()->copy()->subYear()->startOfMonth();
        $end = now()->copy()->endOfMonth();
        $months = [];
        $labels = [];
        $current = $start->copy();
        while ($current <= $end) {
            $key = $current->format('Y-m');
            $months[$key] = collect();
            $labels[] = $current->format('M Y');
            $current->addMonth();
        }
        $assistances = \App\Models\Assistance::whereHas('event', function ($q) use ($start, $end) {
            $q->whereBetween('start_date', [$start, $end]);
        })->get();
        $grouped = $assistances->groupBy(function ($a) {
            return optional($a->event->start_date)->format('Y-m');
        });
        foreach ($months as $month => $val) {
            if (isset($grouped[$month])) {
                $months[$month] = $grouped[$month]->pluck('person_id')->unique();
            }
        }
        $data = [];
        foreach ($months as $ids) {
            $data[] = $ids->count();
        }
        $total = $assistances->pluck('person_id')->unique()->count();
        return [
            'data' => $data,
            'labels' => $labels,
            'total' => $total
        ];
    }

    public function mount()
    {
        $this->events = Event::all();
        $this->lastYearEventsCounts = $this->getLastYearEventsCounts();
        $this->lastYearAssistancesCounts = $this->getLastYearAssistancesCounts();
        $this->lastYearCareersCounts = $this->getLastYearCareersCounts();
        $this->lastYearUniqueParticipantsCounts = $this->getLastYearUniqueParticipantsCounts();
        $this->lastYearEventsPerMonth = $this->getLastYearEventsPerMonth();
        $this->lastYearAssistancesPerMonth = $this->getLastYearAssistancesPerMonth();
        $this->lastYearCareersPerMonth = $this->getLastYearCareersPerMonth();
        $this->lastYearUniqueParticipantsPerMonth = $this->getLastYearUniqueParticipantsPerMonth();
        $this->totalEvents = array_sum($this->lastYearEventsPerMonth['data']);
        $this->totalAssistances = array_sum($this->lastYearAssistancesPerMonth['data']);
        $this->totalCareers = array_sum($this->lastYearCareersPerMonth['data']);
        $this->totalUniqueParticipants = $this->lastYearUniqueParticipantsPerMonth['total'];
    }

    public function render()
    {
        return view('livewire.dashboard-sparks');
    }
}
