<?php

namespace App\Http\Controllers\frontend;

use App\Services\Game;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GameController extends Controller
{
    const AGE_ESRB = 1;
    const AGE_PEGI = 2;

    const AGE_RATING = [
        1 => 'Three',
        2 => 'Seven',
        3 => 'Twelve',
        4 => 'Sixteen',
        5 => 'Eighteen',
        6 => 'RP',
        7 => 'EC',
        8 => 'E',
        9 => 'E10',
        10 => 'T',
        11 => 'M',
        12 => 'AO',
    ];

    public function index(Request $request)
    {

        return view('frontend.game.index');
    }

    public function show($slug)
    {
        dump((new Game)->get($slug));
        return view('frontend.game.show', ['game' => (new Game)->get($slug)]);
    }

    public function resetFilter()
    {
        session()->flush();

        return redirect(route('games.index'));
    }
}
