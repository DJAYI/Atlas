<?php

namespace App\Http\Controllers;

use App\Exports\ReportsExport;
use App\Models\Assistance;
use App\Models\Country;
use App\Models\Event;
use App\Http\Requests\ReportRequest;
use Illuminate\Http\Request;
use Log;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Controller for generating reports related to event assistance.
 *
 * This controller provides functionality to generate Excel reports
 * based on assistance records for a given event. Reports can be filtered
 * by event, type of person (e.g., student), and whether the person is Colombian.
 *
 * @package App\Http\Controllers
 */
class ReportController extends Controller
{

    /**
     * Generate an Excel report of assistance records for a specific event.
     *
     * Retrieves assistance records filtered by event ID, type of person, and
     * whether the person is Colombian. The resulting data is exported as an Excel file.
     *
     * @param ReportRequest $request The HTTP request containing validated parameters:
     *                         - event_id: (int) The ID of the event to filter by (required).
     *                         - type: (string|null) The type of person to filter by (optional).
     *                         - is_colombian: (bool|string|null) Whether to filter by Colombians (optional).
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse The Excel file download response.
     */
    public function generateReport(ReportRequest $request)
    {
        // Data is already validated by ReportRequest
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

        Log::info('Report generated successfully by user: ' . auth()->user()->email . ' at ' . now());
        Log::info('Report details: ' . json_encode($request->all()) . ' at ' . now());

        return Excel::download(new ReportsExport($result, $type, $filterByColombia), 'Reporte Internacional Presencial de SNIES.xlsx');
    }

    public function generateTemplateCertificates(Request $request)
    {
        // Validar que el evento existe
        $eventId = $request->event_id;

        // Aquí puedes implementar la lógica para generar un certificado
        // basándote en la asistencia y el evento.
        // Por ahora, solo retornamos un mensaje de éxito.
        return Excel::download(new \App\Exports\CertificateTemplateExport($eventId), 'plantilla-certificados.xlsx');
    }
}
