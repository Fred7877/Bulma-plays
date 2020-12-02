<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ReleaseDate
 *
 * @property int $id
 * @property array $data
 * @property string $checksum
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Game[] $games
 * @property-read int|null $games_count
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseDate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseDate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseDate query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseDate whereChecksum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseDate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseDate whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseDate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReleaseDate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReleaseDate extends Model
{
    use HasFactory;

    protected $fillable = ['data', 'checksum'];

    protected $casts = [
        'data' => 'array'
    ];

    public function games()
    {
        return $this->hasMany(Game::class);
    }
}
