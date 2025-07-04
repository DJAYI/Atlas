<?php

namespace App\Livewire;

use App\Models\Assistance;
use App\Models\Event;
use App\Models\Activity;
use App\Models\University;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class DashboardCharts extends Component
{
    // Datos para AssistancesBarChart
    public $barChartStatistics = [];

    // Datos para MobilityPieChart
    public $pieChartStatistics = [
        "entrantes" => 0,
        "salientes" => 0,
        "en_casa" => 0,
    ];

    // Datos para TableAssistanceOfLastYearByPeriod
    public $tableByPeriodStatistics = [];
    public $periodLabels = [];

    // Datos para TableTotalActivities
    public $activitiesData = [];
    public $totalResults = [];

    public function mount()
    {
        // Tiempo de caché en segundos (10 segundos)
        $cacheTime = 10;

        // Cargar datos desde caché o calcularlos si la caché ha expirado
        $this->barChartStatistics = Cache::remember('dashboard_bar_chart_statistics', $cacheTime, function () {
            return $this->calculateBarChartData();
        });

        $this->pieChartStatistics = Cache::remember('dashboard_pie_chart_statistics', $cacheTime, function () {
            return $this->calculatePieChartData();
        });

        $cacheData = Cache::remember('dashboard_table_period_statistics', $cacheTime, function () {
            return [
                'statistics' => $this->calculateTableByPeriodData(),
                'periods' => $this->getLastThreePeriodsLabels()
            ];
        });
        $this->tableByPeriodStatistics = $cacheData['statistics'];
        $this->periodLabels = $cacheData['periods'];

        $cacheActivities = Cache::remember('dashboard_activities_data', $cacheTime, function () {
            return [
                'activitiesData' => $this->calculateTableTotalActivitiesData(),
                'totalResults' => $this->calculateTotalResults()
            ];
        });
        $this->activitiesData = $cacheActivities['activitiesData'];
        $this->totalResults = $cacheActivities['totalResults'];
    }

    // Método auxiliar para obtener los últimos tres períodos (solo etiquetas)
    protected function getLastThreePeriodsLabels()
    {
        $currentDate = now();
        $periods = $this->getLastThreeSemesters($currentDate);
        return array_column($periods, 'key');
    }

    // Calcular datos para el gráfico de barras (sin guardarlos en la propiedad)
    protected function calculateBarChartData()
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
                    'emprendedor' => [
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
                    'emprendedor' => [
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
                    'emprendedor' => [
                        'virtual' => ['entrantes' => 0, 'salientes' => 0],
                        'presencial' => ['entrantes' => 0, 'salientes' => 0],
                    ],
                ],
            ];

            // Procesar los datos como lo hace AssistancesBarChart
            $comfenalco = University::where('name', 'Fundación Universitaria Tecnológico Comfenalco')->first();
            $comfenalcoId = $comfenalco ?->id;

            foreach ($events as $event) {
                $location = strtolower($event->location ?: '');
                $modality = strtolower($event->modality ?: '');

                // Verificamos que la ubicación sea una de las válidas
                if (!in_array($location, ['nacional', 'internacional', 'local'])) {
                    \Illuminate\Support\Facades\Log::info("Evento {$event->id} con ubicación no válida: '{$location}'");
                    continue;
                }

                // Verificamos que la modalidad sea una de las válidas
                if (!in_array($modality, ['virtual', 'presencial'])) {
                    \Illuminate\Support\Facades\Log::info("Evento {$event->id} con modalidad no válida: '{$modality}'");
                    continue;
                }

                foreach ($event->assistances as $assistance) {
                    \Illuminate\Support\Facades\Log::debug('Mobilidad de asistencia', [
                        'assistance_id' => $assistance->id,
                        'mobility' => $assistance->mobility,
                    ]);

                    // Verificar si la asistencia tiene movilidad
                    if (!$assistance->mobility) {
                        \Illuminate\Support\Facades\Log::info("Asistencia {$assistance->id} sin movilidad");
                        continue;
                    }

                    // Determinar rol
                    $role = strtolower($assistance->mobility->type ?: '');

                    if (!in_array($role, ['estudiante', 'profesor', 'egresado', 'administrativo', 'emprendedor'])) {
                        \Illuminate\Support\Facades\Log::info("Asistencia {$assistance->id} con rol no válido: '{$role}'");
                        continue;
                    }

                    // Verificar si la persona tiene universidad asociada
                    if (!$assistance->person || !$assistance->person->university) {
                        \Illuminate\Support\Facades\Log::info("Asistencia {$assistance->id} sin universidad asociada");
                        continue;
                    }

                    // Determinar dirección (entrante/saliente)
                    $universityId = $assistance->person->university->id ?? null;
                    if (!$universityId || !$comfenalcoId) {
                        \Illuminate\Support\Facades\Log::info("Asistencia {$assistance->id} sin universidad válida o Comfenalco no encontrado");
                    }
                    $direction = ($universityId == $comfenalcoId) ? 'salientes' : 'entrantes';

                    // Validar claves y sumar
                    if (
                        isset($yearData[$location]) &&
                        isset($yearData[$location][$role]) &&
                        isset($yearData[$location][$role][$modality]) &&
                        isset($yearData[$location][$role][$modality][$direction])
                    ) {
                        $yearData[$location][$role][$modality][$direction]++;
                    } else {
                        \Illuminate\Support\Facades\Log::warning("Estructura no válida: year=$year, location=$location, role=$role, modality=$modality, direction=$direction");
                    }
                }
            }
            $statistics[$year] = $yearData;
        }

        // Log de depuración para ver los datos procesados
        \Illuminate\Support\Facades\Log::info("Datos procesados para gráfico de barras:", ['data' => $statistics]);

        return $statistics;
    }

    // Calcular datos para MobilityPieChart (sin guardarlos en la propiedad)
    protected function calculatePieChartData()
    {
        // Obtener el id real de Comfenalco
        $comfenalco = University::where('name', 'Fundación Universitaria Tecnológico Comfenalco')->first();
        $comfenalcoId = $comfenalco ? $comfenalco->id : null;

        // Solo asistencias de eventos del último año (por start_date)
        $eventIds = Event::where('start_date', '>=', now()->subYear())->pluck('id');
        $lastYearAssistances = Assistance::whereIn('event_id', $eventIds)->with(['person', 'event'])->get();

        if ($lastYearAssistances->isEmpty() || !$comfenalcoId) {
            return [
                "entrantes" => 0,
                "salientes" => 0,
                "en_casa" => 0,
            ];
        }

        return $lastYearAssistances->reduce(function ($carry, $assistance) use ($comfenalcoId) {
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

    // Calcular datos para TableAssistanceOfLastYearByPeriod (sin guardarlos en la propiedad)
    protected function calculateTableByPeriodData()
    {
        $currentDate = now();
        $periods = $this->getLastThreeSemesters($currentDate);
        // Ya no guardamos los periodLabels aquí, se retornan desde getLastThreePeriodsLabels()

        $data = [
            'Internacional Presencial' => [],
            'Nacional Presencial' => [],
            'Internacional Virtual' => [],
            'Nacional Virtual' => [],
            'total' => [],
        ];

        foreach ($periods as $period) {
            $periodKey = $period['key'];

            // Inicializar contadores
            foreach (array_keys($data) as $key) {
                $data[$key][$periodKey] = 0;
            }

            // Contar asistencias por periodo y modalidad usando start_date del evento
            $data['Internacional Presencial'][$periodKey] = Assistance::whereHas('event', function ($q) use ($period) {
                $q->where('location', 'internacional')
                    ->where('modality', 'presencial')
                    ->whereBetween('start_date', [$period['start'], $period['end']]);
            })->count();

            $data['Nacional Presencial'][$periodKey] = Assistance::whereHas('event', function ($q) use ($period) {
                $q->whereIn('location', ['nacional', 'local'])
                    ->where('modality', 'presencial')
                    ->whereBetween('start_date', [$period['start'], $period['end']]);
            })->count();

            $data['Internacional Virtual'][$periodKey] = Assistance::whereHas('event', function ($q) use ($period) {
                $q->where('location', 'internacional')
                    ->where('modality', 'virtual')
                    ->whereBetween('start_date', [$period['start'], $period['end']]);
            })->count();

            $data['Nacional Virtual'][$periodKey] = Assistance::whereHas('event', function ($q) use ($period) {
                $q->whereIn('location', ['nacional', 'local'])
                    ->where('modality', 'virtual')
                    ->whereBetween('start_date', [$period['start'], $period['end']]);
            })->count();

            // Calcular total por periodo
            $data['total'][$periodKey] =
                $data['Internacional Presencial'][$periodKey] +
                $data['Nacional Presencial'][$periodKey] +
                $data['Internacional Virtual'][$periodKey] +
                $data['Nacional Virtual'][$periodKey];
        }

        return $data;
    }

    // Calcular datos para TableTotalActivities (sin guardarlos en la propiedad)
    protected function calculateTableTotalActivitiesData()
    {
        // Obtener todas las actividades
        $activities = Activity::with(['events.assistances'])->get();

        // Agrupar actividades por nombre y contar asistentes y eventos
        return $activities->map(function ($activity) {
            // 1. Cada evento tiene una actividad
            $events = $activity->events;
            // 2. Contar el número de asistentes por evento
            $totalAssistants = $events->sum(function ($event) {
                return $event->assistances->count();
            });
            // 3. Contar el número de eventos por actividad
            $totalActivities = $events->count();

            return [
                'name' => $activity->name,
                'total_assistants' => $totalAssistants,
                'total_activities' => $totalActivities,
            ];
        })->toArray();
    }

    // Calcular totales para TableTotalActivities
    protected function calculateTotalResults()
    {
        $activitiesData = $this->calculateTableTotalActivitiesData();

        // Calcular el total de asistentes y actividades
        return [
            'total_assistants' => collect($activitiesData)->sum('total_assistants'),
            'total_activities' => collect($activitiesData)->sum('total_activities'),
        ];
    }

    // Función auxiliar para obtener los últimos tres semestres
    protected function getLastThreeSemesters($currentDate)
    {
        $year = $currentDate->year;
        $month = $currentDate->month;
        $periods = [];

        // Determinar el semestre actual
        if ($month >= 1 && $month <= 6) {
            // Estamos en el primer semestre del año actual
            $periods[] = [
                'key' => "{$year}-1",
                'start' => "{$year}-01-01",
                'end' => "{$year}-06-30",
            ];
            $periods[] = [
                'key' => ($year - 1) . "-2",
                'start' => ($year - 1) . "-07-01",
                'end' => ($year - 1) . "-12-31",
            ];
            $periods[] = [
                'key' => ($year - 1) . "-1",
                'start' => ($year - 1) . "-01-01",
                'end' => ($year - 1) . "-06-30",
            ];
        } else {
            // Estamos en el segundo semestre del año actual
            $periods[] = [
                'key' => "{$year}-2",
                'start' => "{$year}-07-01",
                'end' => "{$year}-12-31",
            ];
            $periods[] = [
                'key' => "{$year}-1",
                'start' => "{$year}-01-01",
                'end' => "{$year}-06-30",
            ];
            $periods[] = [
                'key' => ($year - 1) . "-2",
                'start' => ($year - 1) . "-07-01",
                'end' => ($year - 1) . "-12-31",
            ];
        }

        return $periods;
    }

    public function render()
    {
        return view('livewire.dashboard-charts');
    }

    /**
     * Limpiar la caché de los datos del dashboard
     * Este método puede ser llamado cuando se necesite actualizar los datos manualmente
     */
    public function refreshData()
    {
        // Limpiar todas las cachés
        Cache::forget('dashboard_bar_chart_statistics');
        Cache::forget('dashboard_pie_chart_statistics');
        Cache::forget('dashboard_table_period_statistics');
        Cache::forget('dashboard_activities_data');

        // Recargar los datos
        $this->mount();

        // Notificar al frontend
        $this->dispatch('dashboard-data-refreshed');
    }
}
