<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use MarcReichel\IGDBLaravel\Models\Game;
use MarcReichel\IGDBLaravel\Models\Platform;

class GameController extends Controller
{
    public function index()
    {

        return view('frontend.game.index');
    }

    public function show($id)
    {
        $game = Game::with(['cover'])->where('id', $id)->first();

        return view('frontend.game.show', ['game' => $game]);
    }
}
