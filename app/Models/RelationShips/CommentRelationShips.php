<?php


namespace App\Models\RelationShips;

use App\Models\Game;
use App\Models\ModerationComment;
use Illuminate\Foundation\Auth\User;

trait CommentRelationShips
{
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function moderations() {
        return $this->hasMany(ModerationComment::class, 'comment_id', 'id');
    }

    public function game() {
        return $this->belongsTo(Game::class, 'game_id', 'game_id');
    }
}
