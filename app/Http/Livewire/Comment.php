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
     * @return array
     */
    private function findChildren()
    {
        $childrens = [];

        foreach ($this->comments as $comment1) {
            $childs = $this->getChildrens($this->comments, $comment1->id);
            if (!$childs->isEmpty()) {
                $childrens[$comment1->id] = $childs;
            }
        }

        return $childrens;
    }

    /**
     * @param $comments
     * @param $id
     * @return mixed
     */
    private function getChildrens($comments, $id)
    {
        dd($comments);

        return $comments->where('parent_comment_id', $id)->filter(function ($item) {

            return isset($item->moderations->last()['status']) &&
                $item->moderations->last()['status'] === Moderation::ModerationOk;
        });
    }

    /**
     * @param null $idComment
     */
    public function sendAnswer($idComment = null)
    {
        if ($idComment !== null) {
            $this->validate([
                'answer' => 'required|min:1',
            ]);

            ModelComment::create([
                'game_id' => $this->game['id'],
                'comment' => $this->answer,
                'type' => $this->type,
                'parent_comment_id' => $idComment,
                'language' => App::getLocale(),
                'user_id' => Auth::user()->id
            ]);

            $this->reset('answer');
        }
    }

    /**
     *
     */
    public function sendComment()
    {
        $this->validate([
            'comment' => 'required|min:1',
        ]);

        ModelComment::create([
            'game_id' => $this->game['id'],
            'comment' => $this->comment,
            'type' => $this->type,
            'language' => App::getLocale(),
            'user_id' => Auth::user()->id
        ]);

        $this->reset('comment');
        $this->reset('tips');
        $this->dispatchBrowserEvent('commentAdded', ['type' => $this->typeDesciption]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.comment');
    }
}
