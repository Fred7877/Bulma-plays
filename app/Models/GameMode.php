<?php

namespace App\Models;

use App\Models\RelationShips\GameModeRelationShipsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameMode extends Model
{
    use HasFactory, GameModeRelationShipsTrait;

    protected $guarded = [];


    protected $casts = ['metas' => 'array'];
}
