<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomGameScreenshot extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customGame()
    {
        return $this->belongsTo(CustomGame::class);
    }
}
