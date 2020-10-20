<?php

namespace App\Http\Livewire;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Component;
use MarcReichel\IGDBLaravel\Models\Game;

class ViewGames extends Component
{
    public $games;
    public $platform = null;
    public $sort;

    private $ttl = 7200;

    protected $listeners = ['platformChange', 'sortChange'];

    public function mount()
    {
        $this->games = Cache::remember('games', $this->ttl, function () {
            return Game::with(['release_dates', 'platforms', 'cover'])
                ->where('first_release_date', '<', Carbon::now())
                ->whereNotNull('first_release_date')
                ->orderByDesc('first_release_date')
                ->get()->toArray();
        });
    }

    public function platformChange($value)
    {
        if ($value === '') {
            $this->platform = null;
        } else {
            $this->platform = $value;
        }

        $this->getGames();
    }

    public function sortChange($value)
    {
        $this->sort = $value;
        $this->getGames();
    }

    private function getGames()
    {
        $keyCache = 'games_' . Str::studly($this->platform) . '_' . $this->sort;

        $this->games = Cache::remember($keyCache, $this->ttl, function () {
            $games = Game::with(['release_dates', 'platforms', 'cover']);
            if ($this->platform !== null) {
                $games->where('platforms.slug', $this->platform);
            }

            $games->where('first_release_date', '<', Carbon::now())
                ->whereNotNull('first_release_date');
            if ($this->sort === 'asc') {
                $games->orderBy('first_release_date');
            } else {
                $games->orderByDesc('first_release_date');
            }

            return $games->get()->toArray();
        });
    }

    public function render()
    {
        return view('livewire.view-games');
    }
}
