<?php

namespace App\Http\Controllers\frontend;

use App\Services\Game;
use Illuminate\Routing\Controller;

class GameController extends Controller
{
    public function index()
    {

        return view('frontend.game.index');
    }

    public function show($id)
    {

        return view('frontend.game.show', ['game' => (new Game)->get($id)]);
    }
}
