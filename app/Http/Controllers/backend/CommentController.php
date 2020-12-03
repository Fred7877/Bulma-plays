<?php

namespace App\Http\Controllers\backend;

use App\DataTables\CommentsDataTable;
use App\Enums\CommentType;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CommentsDataTable $dataTable)
    {
        return $dataTable->render('backend.comment.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Comment $comment)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Comment $comment)
    {

        return View::make('backend.moderation.edit', ['comment' => $comment, 'game' => Game::where('game_id', $comment->game_id)->first()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->update(
            [
                'type' => (int) $request->get('type') === CommentType::Comments ? CommentType::Tips : CommentType::Comments
            ]
        );
        Cache::forget('game-' . $request->get('game_slug') . '-' . App::getLocale());

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
