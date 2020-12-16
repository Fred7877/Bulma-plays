<?php

namespace App\Http\Controllers\frontend;

use App\Services\Game;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use MarcReichel\IGDBLaravel\Models\GameMode;
use MarcReichel\IGDBLaravel\Models\Genre;
use MarcReichel\IGDBLaravel\Models\Platform;
use MarcReichel\IGDBLaravel\Models\PlayerPerspective;
use MarcReichel\IGDBLaravel\Models\Theme;
use function React\Promise\all;

class GameController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check()) {
                View::share('user', Auth::user());
            }
            return $next($request);
        });
    }

    public function index()
    {

        return view('frontend.game.index');
    }

    public function show($slug)
    {

        return view('frontend.game.show', ['game' => (new Game)->get($slug)]);
    }

    public function resetFilter()
    {
        session()->forget(['paginate', 'filter']);

        return redirect(route('games.index'));
    }
}
