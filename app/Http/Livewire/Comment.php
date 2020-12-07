<?php

namespace App\Http\Livewire;

use App\Enums\CommentType;
use App\Enums\Moderation;
use App\Models\Comment as ModelComment;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class Comment extends Component
{
    public $comment;
    public $tips;
    public $game;
    public $comments;
    public $type;
    public $typeDesciption;
    public $answers;
    public $answer;

    /**
     *
     */
    public function mount()
    {
        $this->typeDesciption = Str::lower(CommentType::fromValue($this->type)->description);

        $this->comments = $this->game[$this->typeDesciption]->filter(function ($item) {

            return $item->parent_comment_id === null && isset($item->moderations->last()['status']) &&
                $item->moderations->last()['status'] === Moderation::ModerationOk;
        });

        $this->answers = $this->game[$this->typeDesciption]->filter(function ($item) {

            return $item->parent_comment_id !== null && isset($item->moderations->last()['status']) &&
                $item->moderations->last()['status'] === Moderation::ModerationOk;
        });

    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.comment');
    }
}
