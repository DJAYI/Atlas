<?php

namespace App\Providers;

use App\Models\Country;
use App\Models\University;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class UniversityAttendanceCoordsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Ejecutar solo si han pasado 7 días desde la última ejecución
        $cacheKey = 'university_coords_provider_last_run';
        $lastRun = cache()->get($cacheKey);
        if ($lastRun && now()->diffInDays($lastRun) < 1) {
           
            return;
        }
        cache()->put($cacheKey, now(), now()->addDays(7));

        $requiredTables = ['assistances', 'people', 'universities', 'countries'];
        $missingTables = [];
        foreach ($requiredTables as $table) {
            if (!DB::getSchemaBuilder()->hasTable($table)) {
                $missingTables[] = $table;
            }
        }
        if (!empty($missingTables)) {
            Log::warning('Missing required tables: ' . implode(', ', $missingTables));
            return;
        }
        // Solo universidades con asistentes
        $universities = DB::table('universities')
            ->select('universities.id', 'universities.name', 'universities.lat', 'universities.lng', 'universities.country_id', DB::raw('(SELECT COUNT(1) FROM assistances a JOIN people p ON a.person_id = p.id WHERE p.university_id = universities.id) as total_assistants'))
            ->whereRaw('(SELECT COUNT(1) FROM assistances a JOIN people p ON a.person_id = p.id WHERE p.university_id = universities.id) > 0')
            ->get();
        if ($universities->isEmpty()) {
            Log::info('No universities with assistances found.');
            return;
        }
        foreach ($universities as $u) {
            // Solo si faltan coordenadas
            if (empty($u->lat) || empty($u->lng)) {
                // Verifica si ya se intentó buscar antes (usa un campo extra o log, aquí solo ejemplo de lógica simple)
                $countryName = Country::where('id', $u->country_id)->first()->name ?? 'Unknown Country';
                $query = $u->name . ', ' . $countryName;
                // Si ya existen logs de intento para esta universidad y país, no repite la petición
                $logKey = "coords_attempted_{$u->id}_{$countryName}";
                if (!cache()->has($logKey)) {
                    Log::info("Querying OpenCage API for: {$query}");
                    $response = Http::get('https://api.opencagedata.com/geocode/v1/json', [
                        'q'   => $query,
                        'key' => env('OPENCAGE_API_KEY'),
                        'limit' => 1,
                    ]);
                    cache()->put($logKey, true, now()->addDays(7)); // Evita repetir por 7 días
                    if ($response->ok() && isset($response['results'][0]['geometry'])) {
                        $coords = $response['results'][0]['geometry'];
                        University::where('id', $u->id)->update([
                            'lat' => $coords['lat'],
                            'lng' => $coords['lng'],
                        ]);
                        Log::info("Updated coordinates for {$u->name}: lat={$coords['lat']}, lng={$coords['lng']}");
                    }
                } else {
                    Log::info("Skipping OpenCage API for {$u->name} (already attempted recently)");
                }
            }
        }
    }
}
