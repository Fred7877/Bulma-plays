<?php


namespace App\Http\Controllers\frontend;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Comment as ModelComment;
use App\Models\ModerationComment;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function create(CommentRequest $request)
    {
        $comment = ModelComment::create([
            'game_id' => $request->get('gameId'),
            'comment' => $request->get('comment'),
            'type' => $request->get('type'),
            'parent_comment_id' => $request->get('parentCommentId'),
            'language' => $request->get('lang'),
            'user_id' => Auth::user()->id
        ]);

        if ($comment) {
            return response()->json([], 200);
        }

        return response()->json(['error' => 'error create comment'], 404);
    }

    public function index()
    {
        $comments = Comment::with(['moderations', 'game'])->where('user_id', Auth::user()->id)->orderByDesc('created_at')->get();

        return view('frontend.comment.index', ['comments' => $comments]);
    }

    public function edit(Comment $comment)
    {
        return view('frontend.comment.edit', ['comment' => $comment]);
    }

    public function update(CommentRequest $request, Comment $comment)
    {
        $comment->update([
            'comment' => $request->get('comment')
        ]);

        ModerationComment::create([
            'comment_id' => $comment->id,
            'status' =>null,
        ]);

        return redirect()->route('comments.user.edit', ['comment' => $comment])->with('comment_edited', 'toto');
    }
}
