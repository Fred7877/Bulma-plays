<?php

namespace App\Models;

use App\Models\RelationShips\CommentRelationShips;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Comment extends Model
{
    use HasFactory, CommentRelationShips;

    protected $guarded = [];

}
