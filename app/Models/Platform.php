<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Platform
 *
 * @property int $id
 * @property array $data
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Game[] $games
 * @property-read int|null $games_count
 * @method static \Illuminate\Database\Eloquent\Builder|Platform newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Platform newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Platform query()
 * @method static \Illuminate\Database\Eloquent\Builder|Platform whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Platform whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Platform whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Platform whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Platform whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Platform extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'data' => 'array'
    ];


    public function games()
    {
        return $this->belongsToMany(Game::class, PlatformGame::class);
    }
}
