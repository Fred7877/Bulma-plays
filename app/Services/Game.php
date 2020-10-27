<?php


namespace App\Services;

use Illuminate\Support\Facades\Cache;
use MarcReichel\IGDBLaravel\Models\Game as IGDBGame;

class Game
{
    private $ttl = 7200;

    public function get($id)
    {
        return Cache::remember('game-' . $id, $this->ttl, function () use ($id) {

            $game = IGDBGame::with([
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
                'websites',
            ])->find($id)->toArray();

            (new AutoTranslation)->translate($game['summary'], 'summary', $id);
            $game['translate']['summary'] = getTranslation($id, 'summary');

            return $game;
        });
    }
}
