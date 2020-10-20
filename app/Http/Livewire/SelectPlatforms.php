<?php

namespace App\Http\Livewire;

use Livewire\Component;
use MarcReichel\IGDBLaravel\Models\Platform;

class SelectPlatforms extends Component
{

    public $platforms = [];

    public function mount()
    {
        $this->platforms = Platform::all()->sortBy('name')->toArray();
    }

    public function render()
    {
        return view('livewire.select-platforms');
    }
}
