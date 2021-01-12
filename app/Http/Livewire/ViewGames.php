<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use MarcReichel\IGDBLaravel\Models\Game;
use App\Models\CustomGame as CustomGameModel;

class ViewGames extends Component
{
    public $games;
    public $platform = null;
    public $sort = 'desc';
    public $searchWord;
    private $with = ['release_dates', 'platforms', 'cover', 'genres'];
    public $genre = '';
    public $customGame = false;

    public $offset = 0;
    public $limit = 10;
    public $pageCount;
    public $currentPage = 1;
    public $totalItem;
    public $totalQueryGame;
    public $pageNumber = 1;
    public $directionTemporality = '<';

    private $ttl = 7200;

    protected $listeners = ['platformChange', 'sortChange', 'search', 'genre', 'paginate' => '$refresh', 'changeTemporality'];

    public function mount()
    {
        if (session()->has('paginate')) {
            $this->totalItem = session('paginate')['totalItem'];
            $this->offset = session('paginate')['offset'];
            $this->currentPage = session('paginate')['currentPage'];
            $this->genre = session('paginate')['genre'];
            $this->platform = session('paginate')['platform'];
            $this->searchWord = session('paginate')['searchWord'];
            $this->sort = session('paginate')['sort'];

            $this->paginate(null, $this->currentPage);
        } else {
            $this->totalItem = Cache::remember('total-item-' . Game::count(), $this->ttl, function () {

                return Game::where('first_release_date', '<', Carbon::now())
                    ->whereNotNull('first_release_date')->count();
            });

            // Doit-on vider le cache ? si le nombre de games est différent du nombre en cache, oui
            if ((int)$this->totalItem !== (int)Game::where('first_release_date', '<', Carbon::now())
                    ->whereNotNull('first_release_date')->count()) {

                Cache::flush();
            }

            $this->getGames();
        }
    }

    public function platformChange($value)
    {
        $this->reset('games');
        if ($value === '') {
            $this->platform = null;
        } else {
            $this->platform = $value;
        }
        $this->offset = 0;
        $this->currentPage = 1;

        $this->getGames();
    }

    public function genre($value)
    {
        if ($value !== '') {
            $this->genre = $value;
        } else {
            $this->genre = null;
        }
        $this->offset = 0;
        $this->currentPage = 1;

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
            $this->searchWord = $value;
        } else {
            $this->searchWord = null;
        }

        $this->offset = 0;
        $this->currentPage = 1;

        $this->getGames();
    }

    private function getGames()
    {
        $keyCache = 'games_' . Str::studly($this->directionTemporality.'_'.$this->searchWord . '_' . $this->sort . '_' . $this->platform . '_' . $this->genre . '_' . $this->offset . '_' . App::getLocale().'_'.$this->customGame);

        $this->totalQueryGame = $this->queryGames()->count();
        $this->pageCount = (int)ceil($this->totalQueryGame / $this->limit);

        $games = Cache::remember($keyCache, $this->ttl, function () {
            $query = $this->queryGames();

            $query->offset($this->offset)->limit($this->limit);

            return $query->get()->toArray();
        });

        foreach ($games as $k => $game) {
            if ($this->customGame) {
                $games[$k]['cover']['url'] = Storage::disk('s3')->url($game['image']);
            } else {
                $games[$k]['translate']['summary'] = getTranslation($game['id'], 'summary', App::getLocale());
            }
        }

        session()->put([
            'paginate' => [
                'offset' => $this->offset,
                'currentPage' => $this->currentPage,
                'pageNumber' => $this->pageNumber,
                'totalItem' => $this->totalItem,
                'genre' => $this->genre,
                'platform' => $this->platform,
                'searchWord' => $this->searchWord,
                'sort' => $this->sort,
            ]
        ]);

        $this->games = $games;
    }

    public function paginate($direction, $numberPage = null)
    {
        if ($direction === '+') {
            if (($this->offset + $this->limit) <= $this->totalItem) {
                $this->offset += $this->limit;
                $this->pageNumber += 1;
                $this->currentPage++;
            }
        } else {
            if (($this->offset - $this->limit) >= 0) {
                $this->offset -= $this->limit;
                $this->pageNumber -= 1;
                $this->currentPage--;
            }
        }

        if ($numberPage !== null) {
            $this->offset = ($numberPage - 1) * $this->limit;
            $this->currentPage = $numberPage;
        }

        $this->getGames();
    }

    private function queryGames()
    {
        if ($this->customGame) {
            $query = CustomGameModel::query();
            $query->whereHas('moderations', function(Builder $query){
                $query->where('status', true);
            });
        } else {
            $query = Game::with($this->with);
            $query->where('first_release_date', $this->directionTemporality, Carbon::now());
            $query->orderBy('first_release_date', $this->sort);

        }

        if ($this->searchWord != '') {
            $query->search($this->searchWord);
        }

        if ($this->genre) {
            $query->where('genres.slug', $this->genre);
        }

        if ($this->platform != '') {
            $query->where('platforms.slug', $this->platform);
        }

        return $query;
    }

    public function changeTemporality($temporalityActual)
    {
        if ($temporalityActual) {
            $this->directionTemporality = '<';
        } else {
            $this->directionTemporality = '>';
        }

        $this->getGames();
    }

    public function render()
    {
        return view('livewire.view-games');
    }
}
