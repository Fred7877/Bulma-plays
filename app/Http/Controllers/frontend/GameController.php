<?php

namespace App\Http\Controllers\frontend;

use App\Facades\Game;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class GameController extends Controller
{
    /**
     * GameController constructor.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check()) {
                View::share('user', Auth::user());
            }
            return $next($request);
        });
    }

    /**
     * @param null $customGame
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index($customGame = null)
    {

        return view('frontend.game.index', ['customGame' => $customGame]);
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($slug)
    {

        return view('frontend.game.show', ['game' => Game::get($slug)]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function resetFilter()
    {
        session()->forget(['paginate', 'filter']);

        return redirect(route('games.index'));
    }
}
