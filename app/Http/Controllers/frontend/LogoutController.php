<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * Logout the user.
     *
     */
    public function logout()
    {
        Auth::logout();

        return redirect(route('games.index'));
    }
}
