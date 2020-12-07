<?php


namespace App\Http\Controllers\frontend;


use App\Http\Requests\CommentRequest;
use App\Models\Comment as ModelComment;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class CommentController
{
    public function create(CommentRequest $request)
    {
        $comment = ModelComment::create([
            'game_id' => $request->get('gameId'),
            'comment' => $request->get('comment'),
            'type' => $request->get('type'),
            'parent_comment_id' => $request->get('parentCommentId'),
            'language' => App::getLocale(),
            'user_id' => Auth::user()->id
        ]);

        if ($comment) {
            return response()->json([], 200);
        }

        return response()->json(['error' => 'error create comment'], 404);
    }
}
