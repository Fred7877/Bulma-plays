<?php


namespace App\Models\RelationShips;

use App\Models\GameMode;
use App\Models\Genre;
use App\Models\Link;
use App\Models\Platform;
use App\Models\Productor;
use App\Models\Theme;
use App\Models\User;

/**
 * Trait CustomGameRelationShipsTrait
 * @package App\Models\RelationShips
 */
trait CustomGameRelationShipsTrait
{
    public function genres() {
        return $this->belongsToMany(Genre::class, 'custom_game_genres');
    }

    public function platforms() {
        return $this->belongsToMany(Platform::class, 'custom_game_platforms');
    }

    public function themes() {
        return $this->belongsToMany(Theme::class, 'custom_game_themes');
    }

    public function gameModes() {
        return $this->belongsToMany(GameMode::class, 'custom_game_game_modes')->select('*');
    }

    public function customLinks()
    {
        return $this->hasMany(Link::class);
    }

    public function productors()
    {
        return $this->hasMany(Productor::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
