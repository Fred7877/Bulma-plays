<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use MarcReichel\IGDBLaravel\Models\Game;
use MarcReichel\IGDBLaravel\Models\Platform;

class GameController extends Controller
{
    public function index()
    {

        return view('frontend.game.index');
    }

    public function show($id)
    {
        $game = Cache::remember('game-' . $id, 7200, function () use ($id) {
            return Game::with([
                'cover',
                'videos',
                'game_engines',
                'game_modes',
                'multiplayer_modes',
                'player_perspectives',
                'release_dates',
                'themes',
                'genres',
                'keywords',
                'platforms',
                'screenshots',
            ])->find($id)->toArray();
        });
        dump($game);
        return view('frontend.game.show', ['game' => $game]);
    }
}
