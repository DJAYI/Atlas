<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class MapDataController extends Controller
{
    public function locations()
    {
        // 1. Consultamos los datos agregados por universidad
        $results = DB::table('assistances')
            ->join('people', 'assistances.person_id', '=', 'people.id')
            ->join('universities', 'people.university_id', '=', 'universities.id')
            ->join('countries', 'universities.country_id', '=', 'countries.id')
            ->select(
                'universities.id as university_id',
                'universities.name as university',
                'countries.name as country',
                'universities.lat',
                'universities.lng',
                DB::raw('count(*) as total_assistants')
            )
            ->groupBy(
                'universities.id',
                'universities.name',
                'countries.name',
                'universities.lat',
                'universities.lng'
            )
            ->get();

        $updated = []; // Aquí vamos a guardar qué universidades se geolocalizaron

        // 2. Recorremos los resultados para asegurarnos de que tienen coordenadas
        foreach ($results as $r) {
            // Si no hay latitud o longitud, buscamos vía API
            if (!$r->lat || !$r->lng) {
                $query = urlencode("{$r->university}, {$r->country}");

                // Llamada a OpenCage API para obtener las coordenadas
                $response = Http::get('https://api.opencagedata.com/geocode/v1/json', [
                    'q'   => $query,
                    'key' => env('OPENCAGE_API_KEY'), // Asegúrate de tener esto en tu .env
                    'limit' => 1,
                ]);

                if ($response->ok() && isset($response['results'][0]['geometry'])) {
                    $coords = $response['results'][0]['geometry'];

                    // Persistimos las coordenadas en la base de datos
                    University::where('id', $r->university_id)->update([
                        'lat' => $coords['lat'],
                        'lng' => $coords['lng'],
                    ]);

                    // Actualizamos el objeto en memoria
                    $r->lat = $coords['lat'];
                    $r->lng = $coords['lng'];

                    // Guardamos el nombre de la universidad para fines de depuración o logs
                    $updated[] = $r->university;
                }
            }
        }

        // 3. Devolvemos la respuesta con las ubicaciones y cuáles se actualizaron
        return [
            'locations' => $results,
            'updated' => $updated,
        ];
    }
}
