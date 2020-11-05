<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Component;
use MarcReichel\IGDBLaravel\Models\Genre;
use MarcReichel\IGDBLaravel\Models\Platform;

class FilterGames extends Component
{
    const PLATFORM_FAMILLY_PLAYSTATION = 1;
    const PLATFORM_FAMILLY_XBOX = 2;
    const PLATFORM_FAMILLY_SEGA = 3;
    const PLATFORM_FAMILLY_LINUX = 4;
    const PLATFORM_FAMILLY_NINTENDO = 5;
    const PLATFORM_SLUG_WINDOWS = 'win';
    const PLATFORM_SLUG_LINUX = 'linux';
    const PLATFORM_SLUG_MAC = 'mac';

    public $platformPC;
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
    public $search = '';
    public $genres = '';
    public $genre;
    public $genreName = '';

    public function mount()
    {
        $this->platforms = Cache::remember('platforms', $this->ttl, function () {
            return Platform::all()->sortBy('name')->toArray();
        });

        $this->genres = Cache::remember('genres', $this->ttl, function () {
            return Genre::all()->sortBy('name')->toArray();
        });

        $this->platformPC = collect($this->platforms)->filter(function ($item) {

            if (isset($item['slug'])) {
                return ($item['slug'] === self:: PLATFORM_SLUG_WINDOWS || $item['slug'] === self:: PLATFORM_SLUG_LINUX || $item['slug'] === self:: PLATFORM_SLUG_MAC);
            }

            return false;
        })->toArray();

        $this->platformNintendo = collect($this->platforms)->filter(function ($item) {

            if (isset($item['platform_family'])) {
                return ($item['platform_family'] === self:: PLATFORM_FAMILLY_NINTENDO);
            }
            if (stripos($item['name'], 'Nintendo') !== false) {
                return true;
            }

            return false;
        })->toArray();

        $this->platformOculus = collect($this->platforms)->filter(function ($item) {

            return false !== stripos($item['name'], 'VR');
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
                    $item['platform_family'] === self:: PLATFORM_FAMILLY_PLAYSTATION ||
                    $item['platform_family'] === self:: PLATFORM_FAMILLY_LINUX)
                );
            }

            if (stripos($item['name'], 'VR') !== false ||
                stripos($item['name'], 'Nintendo') !== false ||
                stripos($item['name'], 'Mac') !== false ||
                stripos($item['name'], 'PC (Microsoft Windows)') !== false) {
                return false;
            }

            return true;
        })->sortBy('name')->toArray();

        $this->sortName = __('frontend.descending');

        if (session()->has('filter')) {
            $this->genreName = session('filter')['genreName'] ?? '';
            $this->platformName = session('filter')['platformName'] ?? '';
            $this->genre = session('filter')['genreSlug'] ?? '';
            $this->platform = session('filter')['platformSlug'] ?? '';
            $this->sortName = session('filter')['sortName'] ?? __('frontend.descending');
            $this->search = session('filter')['search'] ?? '';
        }
    }

    public function updatedGenre($value)
    {
        if ($value !== '') {
            $this->genreName = collect($this->genres)->where('slug', $value)->first()['name'];
        } else {
            $this->genreName = '';
        }

        session([
            'filter' => [
                'genreName' => $this->genreName,
                'genreSlug' => $value,
            ]
        ]);

        $this->emitUp('genre', $value);
    }

    public function updatedSearch($value)
    {
        $this->sortName = Str::ucFirst(__('frontend.descending'));
        $this->platformName = '';
        $this->platform = null;
        $this->genreName = '';
        $this->search = $value;

        session([
            'filter' => [
                'search' => $value,
            ]
        ]);

        $this->emitUp('search', $value);
    }

    public function updatedPlatform($value)
    {
        if ($value !== '') {
            $this->search = '';
            $this->platformName = collect($this->platforms)->where('slug', $value)->first()['name'];
        } else {
            $this->platformName = '';
        }

        session([
            'filter' => [
                'platformName' => $this->platformName,
                'platformSlug' => $value,
            ]
        ]);

        $this->emitUp('platformChange', $value);
    }

    public function updatedSort($value)
    {
        $this->sortName = $value === 'asc' ? Str::ucFirst(__('frontend.ascending')) : Str::ucFirst(__('frontend.descending'));
        session([
            'filter' => [
                'sortName' => $this->sortName,
            ]
        ]);

        $this->emitUp('sortChange', $value);
    }

    public function render()
    {
        return view('livewire.filter-games');
    }
}
