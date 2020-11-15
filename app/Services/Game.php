<?php


namespace App\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use MarcReichel\IGDBLaravel\Models\Company;
use MarcReichel\IGDBLaravel\Models\Game as IGDBGame;

class Game
{
    private $ttl = 7200;

    const AGE_ESRB = 1;
    const AGE_PEGI = 2;

    const AGE_RATING = [
        1 => 'Three',
        2 => 'Seven',
        3 => 'Twelve',
        4 => 'Sixteen',
        5 => 'Eighteen',
        6 => 'RP',
        7 => 'EC',
        8 => 'E',
        9 => 'E10',
        10 => 'T',
        11 => 'M',
        12 => 'AO',
    ];

    public function get($slug)
    {
        return Cache::remember('game-' . $slug . '-' . App::getLocale(), $this->ttl, function () use ($slug) {

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
                'age_ratings',
                'involved_companies',
            ])->where('slug', $slug)->first()->toArray();

            if (isset($game['involved_companies'])) {
                $game['compagnies'] = collect($game['involved_companies'])->map(function ($item) {
                    return Company::find($item['company']);
                });
            }

            if (isset($game['age_ratings'])) {
                $game['age_ratings'] = collect($game['age_ratings'])->map(function ($item) {
                    if (isset(self::AGE_RATING[$item['rating']]) && $item['category'] == self::AGE_ESRB) {
                        if (isset(self::AGE_RATING[$item['rating']])) {

                            return asset('storage/assets/images/esrb_' . self::AGE_RATING[$item['rating']] . '.jpg');
                        }
                    } else if (isset(self::AGE_RATING[$item['rating']]) && $item['category'] == self::AGE_PEGI) {
                        if (self::AGE_RATING[$item['rating']] === 'Eighteen') {
                            $esrb = 'AO';
                        } else {
                            $esrb = self::AGE_RATING[$item['rating']];
                        }
                        return asset('storage/assets/images/esrb_' . $esrb . '.jpg');
                    }

                    return null;
                });
            }

            if (isset($game['summary'])) {
                (new AutoTranslation)->translate($game['summary'], 'summary', $game['id']);
                $game['translate']['summary'] = getTranslation($game['id'], 'summary', App::getLocale());
            }

            return $game;
        });
    }
}
