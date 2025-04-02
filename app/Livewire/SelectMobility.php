<?php

namespace App\Livewire;

use App\Models\Mobility;
use Livewire\Component;

class SelectMobility extends Component
{
    // Define public properties for Livewire binding
    public $selectedAssistanceType = '';
    public $mobility = '';
    public $mobilities = [];
    public $type;

    // Use the proper lifecycle hook name
    public function updatedSelectedAssistanceType($value)
    {
        // Load mobilities based on the selected type
        $this->mobilities = Mobility::where('type', $value)->orderBy('name')->get();

        // Reset the mobility selection
        $this->mobility = '';
    }

    public function mount($type = null)
    {
        $this->selectedAssistanceType = $type ?? '';

        if ($this->selectedAssistanceType) {
            $this->mobilities = Mobility::where('type', $this->selectedAssistanceType)
                ->orderBy('name')
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.select-mobility');
    }
}
