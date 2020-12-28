<?php


namespace App\Services;

use App\Enums\CommentType;
use App\Models\Comment;
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

    public function find(int $id)
    {
        return Cache::remember('game-' . $id . '-' . App::getLocale(), $this->ttl, function () use ($id) {

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
            ])->where('id', $id)->first()->toArray();

            return $game;
        });
    }

    public function get(string $slug)
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
                    try {
                        return Company::find($item['company']);
                    } catch (\Exception $e) {
                        return null;
                    }
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

            $commentsTips = Comment::with('user')->where('game_id', $game['id'])->where('language', App::getLocale())->get();
            $game['comments'] = $commentsTips->where('type', CommentType::Comments);
            $game['tips'] = $commentsTips->where('type', CommentType::Tips);

            return $game;
        });
    }
}
