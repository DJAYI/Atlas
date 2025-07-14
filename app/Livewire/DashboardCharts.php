<?php

namespace App\Livewire;

use App\Models\Assistance;
use App\Models\Event;
use App\Models\Activity;
use App\Models\University;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
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
        // Tiempo de caché en minutos (aumentado a 15 minutos para reducir carga en la base de datos)
        $cacheTime = now()->addMinutes(15);

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

        // Obtener y cachear el ID de Comfenalco por más tiempo (1 día), ya que es poco probable que cambie
        $comfenalcoId = Cache::remember('comfenalco_university_id', now()->addDay(), function () {
            return University::where('name', 'Fundación Universitaria Tecnológico Comfenalco')->value('id');
        });

        $statistics = [];
        $validRoles = ['estudiante', 'profesor', 'egresado', 'administrativo', 'emprendedor'];
        $validLocations = ['nacional', 'internacional', 'local'];
        $validModalities = ['virtual', 'presencial'];

        foreach ($years as $year) {
            // Inicializar la estructura de datos para este año
            $yearData = $this->initializeYearDataStructure();
            
            // Optimización: ejecutar una consulta agregada con relaciones selectivas
            $assistanceStats = Cache::remember("assistance_stats_{$year}", now()->addHours(6), function () use ($year, $validLocations, $validModalities, $comfenalcoId, $validRoles) {
                // Obtenemos los datos procesados directamente de la base de datos usando subconsultas y joins
                $query = Assistance::query()
                    ->join('events', 'events.id', '=', 'assistances.event_id')
                    ->join('mobilities', 'mobilities.id', '=', 'assistances.mobility_id')
                    ->join('people', 'people.id', '=', 'assistances.person_id')
                    ->whereYear('events.start_date', $year)
                    ->whereIn('events.location', $validLocations)
                    ->whereIn('events.modality', $validModalities)
                    ->whereIn('mobilities.type', $validRoles)
                    ->whereNotNull('people.university_id')
                    ->select(
                        'events.location',
                        'events.modality',
                        'mobilities.type as role',
                        'people.university_id',
                        \DB::raw('COUNT(*) as total')
                    )
                    ->groupBy('events.location', 'events.modality', 'mobilities.type', 'people.university_id')
                    ->get();
                
                return $query;
            });

            // Procesar los resultados agregados
            foreach ($assistanceStats as $stat) {
                $location = strtolower($stat->location);
                $modality = strtolower($stat->modality);
                $role = strtolower($stat->role);
                $direction = ($stat->university_id == $comfenalcoId) ? 'salientes' : 'entrantes';

                if (
                    isset($yearData[$location]) &&
                    isset($yearData[$location][$role]) &&
                    isset($yearData[$location][$role][$modality]) &&
                    isset($yearData[$location][$role][$modality][$direction])
                ) {
                    $yearData[$location][$role][$modality][$direction] += $stat->total;
                }
            }
            
            $statistics[$year] = $yearData;
        }

        return $statistics;
    }
    
    // Método auxiliar para inicializar la estructura de datos de un año
    private function initializeYearDataStructure()
    {
        $roles = ['estudiante', 'profesor', 'egresado', 'administrativo', 'emprendedor'];
        $locations = ['internacional', 'nacional', 'local'];
        $modalities = ['virtual', 'presencial'];
        $directions = ['entrantes' => 0, 'salientes' => 0];

        $yearData = [];
        foreach ($locations as $location) {
            $yearData[$location] = [];
            foreach ($roles as $role) {
                $yearData[$location][$role] = [];
                foreach ($modalities as $modality) {
                    $yearData[$location][$role][$modality] = $directions;
                }
            }
        }
        
        return $yearData;
    }

    // Calcular datos para MobilityPieChart (sin guardarlos en la propiedad)
    protected function calculatePieChartData()
    {
        // Obtener el id real de Comfenalco (usando el valor cacheado)
        $comfenalcoId = Cache::remember('comfenalco_university_id', now()->addDay(), function () {
            return University::where('name', 'Fundación Universitaria Tecnológico Comfenalco')->value('id');
        });

        if (!$comfenalcoId) {
            return [
                "entrantes" => 0,
                "salientes" => 0,
                "en_casa" => 0,
            ];
        }

        // Optimización: usar agregaciones de base de datos en lugar de cargar todas las asistencias y procesarlas en PHP
        $lastYearDate = now()->subYear();

        // Contar entrantes (no son de Comfenalco)
        $entrantes = Assistance::join('people', 'assistances.person_id', '=', 'people.id')
            ->join('events', 'assistances.event_id', '=', 'events.id')
            ->where('events.start_date', '>=', $lastYearDate)
            ->where('people.university_id', '!=', $comfenalcoId)
            ->count();

        // Contar salientes (son de Comfenalco, pero no internationalization_at_home)
        $salientes = Assistance::join('people', 'assistances.person_id', '=', 'people.id')
            ->join('events', 'assistances.event_id', '=', 'events.id')
            ->where('events.start_date', '>=', $lastYearDate)
            ->where('people.university_id', '=', $comfenalcoId)
            ->where('events.internationalization_at_home', '!=', 'si')
            ->count();

        // Contar en_casa (son de Comfenalco e internationalization_at_home)
        $enCasa = Assistance::join('people', 'assistances.person_id', '=', 'people.id')
            ->join('events', 'assistances.event_id', '=', 'events.id')
            ->where('events.start_date', '>=', $lastYearDate)
            ->where('people.university_id', '=', $comfenalcoId)
            ->where('events.internationalization_at_home', '=', 'si')
            ->count();

        return [
            "entrantes" => $entrantes,
            "salientes" => $salientes,
            "en_casa" => $enCasa,
        ];
    }

    // Calcular datos para TableAssistanceOfLastYearByPeriod (sin guardarlos en la propiedad)
    protected function calculateTableByPeriodData()
    {
        $currentDate = now();
        $periods = $this->getLastThreeSemesters($currentDate);
        
        $data = [
            'Internacional Presencial' => [],
            'Nacional Presencial' => [],
            'Internacional Virtual' => [],
            'Nacional Virtual' => [],
            'total' => [],
        ];
        
        // Inicializar todos los contadores en 0
        foreach ($periods as $period) {
            $periodKey = $period['key'];
            foreach (array_keys($data) as $key) {
                $data[$key][$periodKey] = 0;
            }
        }

        // Optimización: realizar una única consulta para todas las asistencias en los períodos relevantes
        // y procesar los datos en memoria, evitando múltiples consultas
        $startDate = $periods[count($periods)-1]['start']; // Fecha de inicio del periodo más antiguo
        $endDate = $periods[0]['end']; // Fecha de fin del periodo más reciente
        
        $stats = DB::table('assistances')
            ->join('events', 'assistances.event_id', '=', 'events.id')
            ->whereBetween('events.start_date', [$startDate, $endDate])
            ->select(
                'events.location',
                'events.modality',
                'events.start_date',
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('events.location', 'events.modality', 'events.start_date')
            ->get();
            
        // Procesar los resultados para cada periodo
        foreach ($stats as $stat) {
            $eventDate = Carbon::parse($stat->start_date);
            
            // Encontrar a qué periodo corresponde esta fecha
            foreach ($periods as $period) {
                $periodStart = Carbon::parse($period['start']);
                $periodEnd = Carbon::parse($period['end']);
                
                if ($eventDate->between($periodStart, $periodEnd)) {
                    $periodKey = $period['key'];
                    
                    // Determinar la categoría según location y modality
                    if ($stat->location === 'internacional' && $stat->modality === 'presencial') {
                        $data['Internacional Presencial'][$periodKey] += $stat->count;
                    } elseif (in_array($stat->location, ['nacional', 'local']) && $stat->modality === 'presencial') {
                        $data['Nacional Presencial'][$periodKey] += $stat->count;
                    } elseif ($stat->location === 'internacional' && $stat->modality === 'virtual') {
                        $data['Internacional Virtual'][$periodKey] += $stat->count;
                    } elseif (in_array($stat->location, ['nacional', 'local']) && $stat->modality === 'virtual') {
                        $data['Nacional Virtual'][$periodKey] += $stat->count;
                    }
                    
                    break; // Ya encontramos el periodo, no necesitamos seguir buscando
                }
            }
        }
        
        // Calcular totales por periodo
        foreach ($periods as $period) {
            $periodKey = $period['key'];
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
        // Optimización: usar consultas agregadas para obtener los datos directamente
        // en lugar de cargar todas las actividades y procesar en memoria
        $activityStats = Activity::select('activities.id', 'activities.name')
            ->selectRaw('COUNT(DISTINCT events.id) as total_activities')
            ->selectRaw('COUNT(assistances.id) as total_assistants')
            ->leftJoin('events', 'activities.id', '=', 'events.activity_id')
            ->leftJoin('assistances', 'events.id', '=', 'assistances.event_id')
            ->groupBy('activities.id', 'activities.name')
            ->get()
            ->map(function ($activity) {
                return [
                    'name' => $activity->name,
                    'total_assistants' => (int)$activity->total_assistants,
                    'total_activities' => (int)$activity->total_activities,
                ];
            })
            ->toArray();

        return $activityStats;
    }

    // Calcular totales para TableTotalActivities
    protected function calculateTotalResults()
    {
        // Optimización: obtener los totales directamente de la base de datos
        $totalAssistants = Assistance::count();
        $totalActivities = Event::count();
        
        return [
            'total_assistants' => $totalAssistants,
            'total_activities' => $totalActivities,
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
        // Limpiar sólo las cachés relevantes para el dashboard usando un patrón
        Cache::forget('dashboard_bar_chart_statistics');
        Cache::forget('dashboard_pie_chart_statistics');
        Cache::forget('dashboard_table_period_statistics');
        Cache::forget('dashboard_activities_data');

        // También limpiar las cachés específicas de años para asistencias
        $currentYear = now()->year;
        for ($i = $currentYear - 2; $i <= $currentYear; $i++) {
            Cache::forget("assistance_stats_{$i}");
            Cache::forget("events_for_year_{$i}");
        }

        // Recargar los datos
        $this->mount();

        // Notificar al frontend
        $this->dispatch('dashboard-data-refreshed');
    }
}
