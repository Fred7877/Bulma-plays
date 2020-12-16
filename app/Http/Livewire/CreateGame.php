<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CreateGame extends Component
{
    public $platforms;
    public $platformsSelected = [];
    public $selectPlatform;
    public $dateRelease;

    protected $listeners = ['selectedPlatform', 'selectedDateRelease'];

    public function selectedPlatform($platform)
    {
        $this->platformsSelected[] = $this->platforms->whereIn('id', $platform)->pluck('name');
        dd($this->platformsSelected);
    }

    public function selectedDateRelease($dateRelease)
    {
        $this->dateRelease = $dateRelease;
    }

    public function render()
    {
        return view('livewire.create-game');
    }
}
