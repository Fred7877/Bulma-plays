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
    public $searchWord;
    private $with = ['release_dates', 'platforms', 'cover', 'genres'];
    public $genre = '';

    private $ttl = 7200;

    protected $listeners = ['platformChange', 'sortChange', 'search', 'genre'];

    public function mount()
    {
        $this->games = Cache::remember('games', $this->ttl, function () {
            return Game::with($this->with)
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
            $this->searchWord = null;
        }

        $this->getGames();
    }

    public function genre($value)
    {
        $this->genre = $value;
        $this->getGames();
    }

    public function sortChange($value)
    {
        $this->sort = $value;
        $this->getGames();
    }

    public function search($value)
    {
        if ($value !== '') {
            $this->games = Cache::remember('games-search-' . $value, $this->ttl, function () use ($value) {
                return Game::with($this->with)->search($value)->orderByDesc('first_release_date')->get()->toArray();
            });
            $this->searchWord = $value;
        } else {
            $this->searchWord = null;
            $this->getGames();
        }
    }

    private function getGames()
    {

        // On trie sur le search ou non
        if ($this->searchWord !== null) {
            $gamesCache = collect(Cache::get('games-search-' . $this->searchWord));

            if ($this->sort === 'asc') {
                $this->games = $gamesCache->sortBy('first_release_date')->all();
            } else {
                $this->games = $gamesCache->sortByDesc('first_release_date')->all();
            }

        } else {
            $keyCache = 'games_' . Str::studly($this->platform . '_' . $this->sort.'_'.$this->genre);

            $this->games = Cache::remember($keyCache, $this->ttl, function () {
                $games = Game::with($this->with);
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

                if ($this->genre) {
                    $games->where('genres.slug', $this->genre);
                }

                return $games->get()->toArray();
            });
        }
    }

    public function render()
    {
        return view('livewire.view-games');
    }
}
