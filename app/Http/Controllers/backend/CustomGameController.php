<?php

namespace App\Http\Controllers\backend;

use App\DataTables\CustomGameDataTable;
use App\Enums\Moderation;
use App\Http\Controllers\Controller;
use App\Models\CustomGame;
use App\Models\ModerationCustomGame;
use Illuminate\Http\Request;

class CustomGameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CustomGameDataTable $dataTable
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(CustomGameDataTable $dataTable)
    {
        return $dataTable->render('backend.custom-game.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CustomGame $customGame
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(CustomGame $customGame)
    {
        return view('backend.moderation.custom-game', ['customGame' => $customGame]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param CustomGame $customGame
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, CustomGame $customGame)
    {
        ModerationCustomGame::create([
            'custom_game_id' => $customGame->id,
            'status' => $request->has('moderation_ok') ? Moderation::ModerationOk : Moderation::ModerationNOk,
            'comment' => $request->get('comment'),
        ]);

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
