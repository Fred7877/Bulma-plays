<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Translation
 *
 * @property int $id
 * @property int $game_id
 * @property string $field
 * @property array $translations
 * @property string $md5
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Game $game
 * @method static \Illuminate\Database\Eloquent\Builder|Translation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereField($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereMd5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereTranslations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Translation extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = ['translations' => 'array'];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
