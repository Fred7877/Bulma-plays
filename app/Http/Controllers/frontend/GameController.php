<?php

namespace App\Http\Controllers\frontend;

use App\Jobs\SendEmailValidationEmailJob;
use App\Services\Game;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

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

    public function index($customGame = null)
    {
        SendEmailValidationEmailJob::dispatch(Auth::user());
        return view('frontend.game.index', ['customGame' => $customGame]);
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
