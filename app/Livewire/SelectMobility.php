<?php

namespace App\Livewire;

use App\Models\Mobility;
use Livewire\Component;

class SelectMobility extends Component
{
    public $selectedAssistanceType;
    public $mobility;
    public $mobilities = [];

    public function updatedSelectedAssistanceType()
    {
        // Cargar las opciones de movilidad según el tipo seleccionado
        $this->mobilities = Mobility::where('type', $this->selectedAssistanceType)->get();

        // Reiniciar la selección de movilidad cuando cambia el tipo de asistencia
        $this->mobility = null;
    }

    public function render()
    {
        return view('livewire.select-mobility');
    }
}
