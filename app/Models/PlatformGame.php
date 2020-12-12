<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\PlatformGame
 *
 * @property int $id
 * @property int $game_id
 * @property int $platform_id
 * @method static \Illuminate\Database\Eloquent\Builder|PlatformGame newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlatformGame newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PlatformGame query()
 * @method static \Illuminate\Database\Eloquent\Builder|PlatformGame whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlatformGame whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PlatformGame wherePlatformId($value)
 * @mixin \Eloquent
 */
class PlatformGame extends Pivot
{
    use HasFactory;

    protected $table = 'platform_games';
}
