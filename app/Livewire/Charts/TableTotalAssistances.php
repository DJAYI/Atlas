<?php

namespace App\Livewire\Charts;

use App\Exports\AssistancesExport;
use App\Models\Assistance;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;

class TableTotalAssistances extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 50;
    public $showAll = false;
    public $isLoading = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function toggleShowAll()
    {
        $this->showAll = !$this->showAll;
        $this->resetPage();
    }

    public function getAssistancesProperty()
    {
        $query = Assistance::with([
            'person:id,firstname,middlename,lastname,second_lastname,document_type,document_number,email,phone,genre,birth_date,minority,university_id,country_id,career_id',
            'person.university:id,name',
            'person.career:id,name',
            'person.country:id,name',
            'event:id,name,modality,description,activity_id,career_id',
            'event.activity:id,name',
            'event.career:id,name',
            'mobility:id,name,type'
        ])->latest('created_at');

        // Aplicar filtro de búsqueda si existe
        if ($this->search) {
            $query->where(function($q) {
                $q->whereHas('person', function($personQuery) {
                    $personQuery->where('firstname', 'like', '%' . $this->search . '%')
                        ->orWhere('lastname', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('document_number', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('event', function($eventQuery) {
                    $eventQuery->where('name', 'like', '%' . $this->search . '%');
                });
            });
        }

        // Retornar paginado o todos según la configuración
        if ($this->showAll) {
            return $query->get();
        } else {
            return $query->paginate($this->perPage);
        }
    }

    public function getAllAssistancesForExport()
    {
        return Cache::remember('all_assistances_export', 300, function() {
            return Assistance::with([
                'person:id,firstname,middlename,lastname,second_lastname,document_type,document_number,email,phone,genre,birth_date,minority,university_id,country_id,career_id',
                'person.university:id,name',
                'person.career:id,name', 
                'person.country:id,name',
                'event:id,name,modality,description,activity_id,career_id',
                'event.activity:id,name',
                'event.career:id,name',
                'mobility:id,name,type'
            ])->get();
        });
    }

    public function downloadExcel()
    {
        $this->isLoading = true;
        
        try {
            $assistances = $this->getAllAssistancesForExport();
            return Excel::download(new AssistancesExport($assistances), 'Reporte de Asistencias Totales.xlsx');
        } finally {
            $this->isLoading = false;
        }
    }

    public function render()
    {
        return view('livewire.charts.table-total-assistances', [
            'assistances' => $this->assistances,
            'totalCount' => Assistance::count()
        ]);
    }
}
