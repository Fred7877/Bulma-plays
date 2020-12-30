<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productor extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customGame()
    {
        return $this->belongsTo(CustomGame::class);
    }
}
