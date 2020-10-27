<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
