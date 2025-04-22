<?php

namespace App\Livewire;

use App\Models\Assistance;
use Illuminate\Support\Collection;
use Livewire\Component;

class DashboardCharts extends Component
{
    public string $movilitySelected = 'estudiante';
    public string $modalitySelected = 'presencial';
    public Collection $counts;

    public function handleMovilitySelected(string $movility): void
    {
        $this->movilitySelected = $movility;
        $this->updateAssistances();
    }

    public function handleModalitySelected(string $modality): void
    {
        $this->modalitySelected = $modality;
        $this->updateAssistances();
    }

    private function fetchAssistancesByYear(): Collection
    {
        $currentYear = now()->year;
        $counts = collect();

        for ($i = 0; $i < 3; $i++) {
            $year = $currentYear - $i;

            $data = Assistance::whereHas('mobility', function ($query) {
                $query->where('type', $this->movilitySelected);
            })
                ->whereHas('event', function ($query) {
                    $query->where('modality', $this->modalitySelected);
                })
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', now()->month)
                ->with(['event', 'person.university']) // Eager load event and person->university relationships
                ->get();

            // Classify as outgoing or incoming
            $outgoingNational = $data->where('event.location', 'nacional')
                ->where('person.university.name', 'FUNDACIÓN UNIVERSITARIA TECNOLÓGICO COMFENALCO')
                ->count();

            $incomingNational = $data->where('event.location', 'nacional')
                ->where('person.university.name', '!=', 'FUNDACIÓN UNIVERSITARIA TECNOLÓGICO COMFENALCO')
                ->count();

            $outgoingInternational = $data->where('event.location', 'internacional')
                ->where('person.university.name', 'FUNDACIÓN UNIVERSITARIA TECNOLÓGICO COMFENALCO')
                ->count();

            $incomingInternational = $data->where('event.location', 'internacional')
                ->where('person.university.name', '!=', 'FUNDACIÓN UNIVERSITARIA TECNOLÓGICO COMFENALCO')
                ->count();

            $counts->put($year, [
                'outgoing_national' => $outgoingNational,
                'incoming_national' => $incomingNational,
                'outgoing_international' => $outgoingInternational,
                'incoming_international' => $incomingInternational,
            ]);
        }

        return $counts;
    }

    private function updateAssistances(): void
    {
        $this->counts = $this->fetchAssistancesByYear();
    }

    public function mount(): void
    {
        $this->updateAssistances();
    }

    public function render()
    {
        return view('livewire.dashboard-charts', [
            'counts' => $this->counts,
        ]);
    }
}
