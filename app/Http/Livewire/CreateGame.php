<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CreateGame extends Component
{
    public $platforms;
    public $platformsSelected = [];
    public $selectPlatform;
    public $dateRelease;

    protected $listeners = ['selectedPlatform', 'selectedDateRelease', 'unSelectedPlatform'];

    public function unSelectedPlatform($platform)
    {
        if ($platform === 'all') {
            $this->platformsSelected = [];
        } else {
            unset($this->platformsSelected[$platform]);
        }
    }

    public function selectedPlatform($platform)
    {
        if ($platform === 'all') {
            $this->platformsSelected = $this->platforms->pluck('name')->all();
        } else {
            $this->platformsSelected[$platform] = $this->platforms->where('id', $platform)->pluck('name')->first();
        }
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
