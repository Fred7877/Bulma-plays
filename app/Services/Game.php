<?php


namespace App\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use MarcReichel\IGDBLaravel\Models\Game as IGDBGame;

class Game
{
    private $ttl = 7200;

    public function get($slug)
    {
        return Cache::remember('game-' . $slug.'-'.App::getLocale(), $this->ttl, function () use ($slug) {

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
            ])->where('slug', $slug)->first()->toArray();

            (new AutoTranslation)->translate($game['summary'], 'summary', $game['id']);
            $game['translate']['summary'] = getTranslation($game['id'], 'summary', App::getLocale());

            return $game;
        });
    }
}
