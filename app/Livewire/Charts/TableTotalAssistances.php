<?php

namespace App\Livewire\Charts;

use App\Exports\AssistancesExport;
use App\Models\Assistance;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class TableTotalAssistances extends Component
{

    public $assistances;

    public function getAssistances()
    {
        $this->assistances = Assistance::all();
    }

    public function downloadExcel()
    {
        return Excel::download(new AssistancesExport($this->assistances), 'Reporte de Asistencias Totales.xlsx');
    }

    public function mount()
    {
        $this->getAssistances();
    }

    public function render()
    {
        return view('livewire.charts.table-total-assistances', [
            'assistances' => $this->assistances,
        ]);
    }
}
