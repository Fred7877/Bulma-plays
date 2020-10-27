<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['data', 'slug'];

    protected $casts = [
        'data' => 'array'
    ];

    public function platforms()
    {
        return $this->belongsToMany(Platform::class, PlatformGame::class);
    }

    public function releaseDate()
    {
        return $this->hasOne(ReleaseDate::class);
    }
}
