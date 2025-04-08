<?php

namespace App\Http\Controllers;

use App\Models\Assistance;
use App\Models\Event;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function generateReport(Request $request)
    {
        $eventId = $request->query('event_id');
        $type = $request->query('type');
        $filterByColombia = $request->query('is_colombian');
        $colombiaId = 1;

        $query = Assistance::with('person')->where('event_id', $eventId);

        // Filtrar por si es colombiano o no
        if (!is_null($filterByColombia)) {
            $query->whereHas('person', function ($q) use ($filterByColombia, $colombiaId) {
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

        dd($result->toArray());
    }
}
