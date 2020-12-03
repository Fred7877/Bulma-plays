<?php

namespace App\Http\Livewire;
use App\Enums\CommentType;
use App\Models\Comment as ModelComment;

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

    protected $rules = [
        'comment' => 'required|min:1',
    ];

    public function mount()
    {
        $this->typeDesciption = Str::lower(CommentType::fromValue($this->type)->description);

        $this->comments = $this->game[$this->typeDesciption];
    }

    public function sendComment()
    {
        $this->validate();

        ModelComment::create([
            'game_id' => $this->game['id'],
            'comment' => $this->comment,
            'type' => $this->type,
            'user_id' => 1
        ]);

        $this->reset('comment');
        $this->reset('tips');
        $this->dispatchBrowserEvent('commentAdded', ['type' => $this->typeDesciption]);
    }

    public function render()
    {

        return view('livewire.comment');
    }
}
