<?php

namespace App\Http\Controllers;

use App\Exports\ReportsExport;
use App\Models\Assistance;
use App\Models\Country;
use App\Models\Event;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{

    /**
     * Generate a report based on the event ID and optional filters.
     * 
     * This method retrieves assistance records filtered by event ID, 
     * type of person, and whether the person is Colombian or not.
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function generateReport(Request $request)
    {
        // Validar que el evento existe
        $eventId = $request->query('event_id');
        $type = $request->query('type');
        $filterByColombia = $request->query('is_colombian');
        $colombiaId = Country::where('name', 'Colombia')->first()->id;

        $query = Assistance::with('person')->where('event_id', $eventId);

        // Filtrar por si es colombiano o no
        if (!is_null($filterByColombia)) {
            $query->whereHas('person', function ($q) use ($filterByColombia, $colombiaId) {
                // FILTER_VALIDATE_BOOLEAN convierte el valor a booleano
                // Si es verdadero, solo colombianos
                // Si es falso, todos menos los colombianos
                // Si es null, no se aplica filtro
                // Si el valor es un string, lo convertimos a booleano
                if (filter_var($filterByColombia, FILTER_VALIDATE_BOOLEAN)) {
                    // Solo colombianos
                    $q->where('country_id', $colombiaId);
                } else {
                    // Todos menos los colombianos
                    $q->where(function ($subQuery) use ($colombiaId) {
                        $subQuery->whereNull('country_id')->orWhere('country_id', '!=', $colombiaId);
                    });
                }
            });
        }

        // Filtrar por tipo de persona (ej. estudiante)
        if (!empty($type)) {
            $query->whereHas('person', function ($q) use ($type) {
                $q->where('type', $type);
            });
        }

        $result = $query->get();

        return Excel::download(new ReportsExport($result, $type, $filterByColombia), 'report.xlsx');
    }
}
