<?php

namespace App\Models;

use App\Models\RelationShips\CustomGameRelationShipsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModerationComment extends Model
{
    use HasFactory, CustomGameRelationShipsTrait;

    protected $guarded = [];
}
