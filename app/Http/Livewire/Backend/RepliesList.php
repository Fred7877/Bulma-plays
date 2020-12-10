<?php

namespace App\Http\Livewire\Backend;

use App\Enums\Languages;
use App\Enums\Moderation as EnumModeration;
use App\Models\Comment;
use App\Models\Moderation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Livewire\Component;

class RepliesList extends Component
{
    public $game;
    public $comment;
    public $comments;
    public $replies = [];
    public $isOpen;
    public $moderation;
    public $level = 1;
    public $waitingModeration = [];

    public function mount()
    {
        if($this->game) {
            $this->comments = Comment::where('game_id', $this->game->game_id)->get();
            $this->replies = $this->comments->where('parent_comment_id', $this->comment->id);

            $this->waitingModeration = $this->comments->filter(function($item){
                return $item->moderations->isEmpty();
            });
        }

    }

    public function backRepliesList($idParentComment)
    {
        $this->getAnswers($idParentComment);
        $this->level--;
    }

    public function moderation($replyId, $status, $slug, $parentId)
    {
        Moderation::create([
            'comment_id' => $replyId,
            'status' => $status,
        ]);

        foreach (Languages::getKeys() as $lang) {
            Cache::forget('game-' . $slug . '-' . $lang);
        }

        $this->getAnswers($parentId);
    }

    public function showReplies($idComment)
    {
        $this->getAnswers($idComment);
        $this->level++;
    }

    private function getAnswers($idComment)
    {
        $replies = Comment::where('parent_comment_id', $idComment)->get();

        $comments = $this->comments;

        $replies->each(function ($item) use($comments) {
            $item['parent'] = Comment::find($item->parent_comment_id);

            $item['childrens'] = $comments->where('parent_comment_id', $item->id);

            if ($item->moderations->first() === null)
                $item['statusClass'] = 'btn-primary';
            elseif ((int)$item->moderations->last()->status === EnumModeration::ModerationNOk)
                $item['statusClass'] = 'btn-danger';
            else
                $item['statusClass'] = 'btn-success';


            $item['statusModeration'] = 'Status : ';
            if ($item->moderations->first() === null)
                $item['statusModeration'] .= '-';
            else
                $item['statusModeration'] .= EnumModeration::getDescription($item->moderations->last()->status);

            return $item;
        });

        $this->replies = $replies;
    }

    public function render()
    {
        return View::make('livewire.backend.replies-list');
    }
}
