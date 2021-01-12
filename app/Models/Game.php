<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Game
 *
 * @property int $id
 * @property array $data
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Platform[] $platforms
 * @property-read int|null $platforms_count
 * @property-read \App\Models\ReleaseDate|null $releaseDate
 * @method static \Illuminate\Database\Eloquent\Builder|Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game query()
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Game extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'igdb' => 'array'
    ];

    public function releaseDate()
    {
        return $this->hasOne(ReleaseDate::class);
    }
}
