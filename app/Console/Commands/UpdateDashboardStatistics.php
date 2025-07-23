<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Activity;
use App\Models\Event;
use App\Models\University;
use App\Models\Assistance;

class UpdateDashboardStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:update-stats {--force : Forzar actualización sin importar la última fecha}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza las estadísticas precalculadas para el dashboard';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lastUpdate = DB::table('dashboard_statistics')->max('updated_at');
        $forceUpdate = $this->option('force');
        
        // Verificar si ha pasado suficiente tiempo desde la última actualización (6 horas)
        if (!$forceUpdate && $lastUpdate && now()->diffInHours($lastUpdate) < 6) {
            $this->info('Las estadísticas ya están actualizadas (última actualización: ' . $lastUpdate . ')');
            return;
        }
        
        $this->info('Actualizando estadísticas del dashboard...');
        
        // 1. Comfenalco ID (importante para varias consultas)
        $comfenalcoId = University::where('name', 'Fundación Universitaria Tecnológico Comfenalco')->value('id');
        
        if (!$comfenalcoId) {
            $this->error('Universidad Comfenalco no encontrada');
            return;
        }
        
        // 2. Actualizar estadísticas por año/localización/modalidad/rol/dirección
        $this->updateDashboardStatistics($comfenalcoId);
        
        // 3. Actualizar estadísticas de actividades
        $this->updateActivityStatistics();
        
        $this->info('Estadísticas actualizadas correctamente');
    }
    
    /**
     * Actualiza las estadísticas principales del dashboard
     */
    private function updateDashboardStatistics($comfenalcoId)
    {
        $currentYear = now()->year;
        $years = [$currentYear - 2, $currentYear - 1, $currentYear];
        $validRoles = ['estudiante', 'profesor', 'egresado', 'administrativo', 'empresario'];
        $validLocations = ['nacional', 'internacional', 'local'];
        $validModalities = ['virtual', 'presencial'];
        
        // Comenzar transacción
        DB::beginTransaction();
        
        try {
            // Eliminar registros anteriores
            DB::table('dashboard_statistics')->whereIn('year', $years)->delete();
            
            // Para cada año relevante
            foreach ($years as $year) {
                $this->info("Procesando estadísticas para el año $year...");
                
                // Obtener datos agregados por año/localización/modalidad/rol/universidad
                $stats = DB::table('assistances')
                    ->join('events', 'assistances.event_id', '=', 'events.id')
                    ->join('mobilities', 'assistances.mobility_id', '=', 'mobilities.id')
                    ->join('people', 'assistances.person_id', '=', 'people.id')
                    ->whereYear('events.start_date', $year)
                    ->whereIn('events.location', $validLocations)
                    ->whereIn('events.modality', $validModalities)
                    ->whereIn('mobilities.type', $validRoles)
                    ->select(
                        DB::raw("$year as year"),
                        'events.location',
                        'events.modality',
                        'mobilities.type as role',
                        DB::raw("CASE WHEN people.university_id = $comfenalcoId THEN 'salientes' ELSE 'entrantes' END as direction"),
                        DB::raw('COUNT(*) as count')
                    )
                    ->groupBy('events.location', 'events.modality', 'mobilities.type', 
                              DB::raw("CASE WHEN people.university_id = $comfenalcoId THEN 'salientes' ELSE 'entrantes' END"))
                    ->get();
                
                // Insertar resultados en la tabla de estadísticas
                foreach ($stats as $stat) {
                    DB::table('dashboard_statistics')->insert([
                        'year' => $stat->year,
                        'location' => $stat->location,
                        'modality' => $stat->modality,
                        'role' => $stat->role,
                        'direction' => $stat->direction,
                        'count' => $stat->count,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
            
            DB::commit();
            $this->info("Estadísticas de dashboard actualizadas");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Error al actualizar estadísticas: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Actualiza las estadísticas de actividades
     */
    private function updateActivityStatistics()
    {
        $this->info("Actualizando estadísticas de actividades...");
        
        DB::beginTransaction();
        
        try {
            // Limpiar tabla
            DB::table('activity_statistics')->truncate();
            
            // Obtener estadísticas por actividad
            $activityStats = Activity::select('activities.id')
                ->selectRaw('COUNT(DISTINCT events.id) as total_events')
                ->selectRaw('COUNT(assistances.id) as total_assistances')
                ->leftJoin('events', 'activities.id', '=', 'events.activity_id')
                ->leftJoin('assistances', 'events.id', '=', 'assistances.event_id')
                ->groupBy('activities.id')
                ->get();
            
            // Insertar estadísticas
            foreach ($activityStats as $stat) {
                DB::table('activity_statistics')->insert([
                    'activity_id' => $stat->id,
                    'total_events' => $stat->total_events,
                    'total_assistances' => $stat->total_assistances,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            
            DB::commit();
            $this->info("Estadísticas de actividades actualizadas");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Error al actualizar estadísticas de actividades: " . $e->getMessage());
            throw $e;
        }
    }
}
