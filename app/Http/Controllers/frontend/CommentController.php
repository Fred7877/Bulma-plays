<?php


namespace App\Http\Controllers\frontend;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Game as ModelGame;
use App\Models\Comment as ModelComment;
use App\Models\ModerationComment;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use MarcReichel\IGDBLaravel\Models\Game;

class CommentController extends Controller
{
    /**
     * @param CommentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
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

        $this->createRelationIfNotExist($comment);

        if ($comment) {
            return response()->json([], 200);
        }

        return response()->json(['error' => 'error create comment'], 404);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $comments = Comment::with(['moderations', 'game'])->where('user_id', Auth::user()->id)->orderByDesc('created_at')->get();

        return view('frontend.comment.index', ['comments' => $comments]);
    }

    /**
     * @param ModelComment $comment
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Comment $comment)
    {
        return view('frontend.comment.edit', ['comment' => $comment]);
    }

    /**
     * @param CommentRequest $request
     * @param ModelComment $comment
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * @param $comment
     */
    private function createRelationIfNotExist($comment)
    {
        if (ModelGame::find($comment->game_id) === null) {
            $igdbGame = Game::find($comment->game_id);
            ModelGame::firstOrCreate(
                [
                    'slug' => $igdbGame->slug,
                    'game_id' => $igdbGame->id,
                    'platform' => implode(',', $igdbGame->platforms)
                ],
                [
                    'igdb' => $igdbGame->toArray(),
                ],
            );
        }
    }
}
