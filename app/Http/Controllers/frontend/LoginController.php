<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\GamerLoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Login the user.
     *
     * @param GamerLoginRequest $request
     * @return string
     */
    public function authenticate(GamerLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            return response()->json(['name' => Auth::user()->name], 200);
        }

        return response()->json(['error' => 'Unkown user'], 404);
    }
}
