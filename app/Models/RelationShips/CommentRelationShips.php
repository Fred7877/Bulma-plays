<?php


namespace App\Models\RelationShips;

use App\Models\Comment;
use App\Models\Game;
use App\Models\Moderation;
use Illuminate\Foundation\Auth\User;

trait CommentRelationShips
{
    /**
     * @return mixed
     */
    public function answers() {
        return $this->hasMany(Comment::class, 'id', 'parent_comment_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function moderations() {
        return $this->hasMany(Moderation::class, 'comment_id', 'id');
    }
}
