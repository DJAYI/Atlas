<?php

namespace App\Livewire;

use App\Models\Mobility;
use Illuminate\Support\Collection;
use Livewire\Component;

class SelectMobility extends Component
{

    public $selectedAssistanceType;
    public $mobility;

    public function getMobilitiesProperty()
    {
        return Mobility::where('type', $this->selectedAssistanceType)->get();
    }

    public function render()
    {
        return view('livewire.select-mobility');
    }
}
