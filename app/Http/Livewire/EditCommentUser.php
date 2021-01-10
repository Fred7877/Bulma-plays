<?php

namespace App\Http\Livewire;

use Livewire\Component;

class EditCommentUser extends Component
{
    public $comment;
    public $commentTxt;
    public $commentVal;
    public $editable = false;

    public function mount()
    {
        $this->commentTxt = $this->comment->comment;
    }

    public function editable()
    {
        $this->editable = !$this->editable;
    }

    public function render()
    {
        return view('livewire.edit-comment-user');
    }
}
