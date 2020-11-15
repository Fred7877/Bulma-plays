<?php

namespace App\Http\Controllers\frontend;

use App\Services\Game;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GameController extends Controller
{
    public function index()
    {

        return view('frontend.game.index');
    }

    public function show($slug)
    {
       // dump((new Game)->get($slug));
        return view('frontend.game.show', ['game' => (new Game)->get($slug)]);
    }

    public function resetFilter()
    {
        session()->flush();

        return redirect(route('games.index'));
    }
}
