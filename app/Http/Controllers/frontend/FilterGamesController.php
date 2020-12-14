<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use MarcReichel\IGDBLaravel\Models\Game;

class FilterGamesController extends Controller
{

    /**
     * @param $platformSlug
     * @param $platformName
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index( $platformSlug, $platformName)
    {
        $keyCache = 'games_' . Str::studly('' . '_' . 'desc' . '_' . $platformSlug . '_' . '' . '_' . '' . '_' . App::getLocale());
        $games = Cache::remember($keyCache, 3600, function() use($platformSlug) {
            $query = Game::with(['platforms']);

            $query->where('first_release_date', '<', Carbon::now());
            $query->where('platforms.slug', $platformSlug);
            $query->orderBy('first_release_date', 'desc');

            return $query->get()->toArray();
        });

        session()->put([
            'paginate' => [
                'offset' => 0,
                'currentPage' => 1,
                'pageNumber' => 1,
                'genre' => '',
                'searchWord' => '',
                'totalItem' => count($games),
                'platform' => $platformSlug,
                'sort' => 'desc',
            ],
            'filter' => [
                'platformName' => $platformName,
                'platformSlug' => $platformSlug,
            ]
        ]);

        return redirect(route('games.index', [], false));
    }
}
