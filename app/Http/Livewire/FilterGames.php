<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use MarcReichel\IGDBLaravel\Models\Platform;

class FilterGames extends Component
{
    const PLATFORM_FAMILLY_PLAYSTATION = 1;
    const PLATFORM_FAMILLY_XBOX = 2;
    const PLATFORM_FAMILLY_SEGA = 3;
    const PLATFORM_FAMILLY_LINUX = 4;
    const PLATFORM_FAMILLY_NINTENDO = 5;

    public $platformNintendo;
    public $platformOculus;
    public $platformPlaystation;
    public $Othersplatforms;
    public $platforms;
    public $platform = null;
    private $ttl = 7200;
    public $sort;
    public $platformName = '';
    public $sortName = '';

    public function mount()
    {
        $this->platforms = Cache::remember('platforms', $this->ttl, function () {
            return Platform::all()->sortBy('name')->toArray();
        });

        $this->platformNintendo = collect($this->platforms)->filter(function ($item) {

            if (isset($item['platform_family'])) {
                return ($item['platform_family'] === self:: PLATFORM_FAMILLY_NINTENDO);
            }
            if (strpos($item['name'], 'Nintendo') !== false) {
                return true;
            }

            return false;
        })->toArray();

        $this->platformOculus = collect($this->platforms)->filter(function ($item) {

            return false !== strpos($item['name'], 'VR');
        })->toArray();

        $this->platformPlaystation = collect($this->platforms)->filter(function ($item) {

            if (isset($item['platform_family'])) {
                return $item['platform_family'] === self:: PLATFORM_FAMILLY_PLAYSTATION;
            }
            return false;
        })->toArray();

        $this->Othersplatforms = collect($this->platforms)->filter(function ($item) {
            if (isset($item['platform_family'])) {
                return (
                !($item['platform_family'] === self:: PLATFORM_FAMILLY_NINTENDO ||
                    $item['platform_family'] === self:: PLATFORM_FAMILLY_PLAYSTATION)
                );
            }

            if (strpos($item['name'], 'VR') !== false || strpos($item['name'], 'Nintendo') !== false) {
                return false;
            }

            return true;
        })->sortBy('name')->toArray();
    }

    public function updatedPlatform($value)
    {

        $this->platformName = collect($this->platforms)->where('slug', $value)->first()['name'];
        $this->emitUp('platformChange', $value);
    }

    public function updatedSort($value)
    {
        $this->sortName = $value === 'asc' ? 'Ascendant' : 'Descendant';
        $this->emitUp('sortChange', $value);
    }

    public function render()
    {
        return view('livewire.filter-games');
    }
}
