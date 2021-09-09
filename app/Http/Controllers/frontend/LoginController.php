<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\GamerLoginRequest;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     *
     * Login the user.
     *
     * @param GamerLoginRequest $request
     * @return string
     */
    public function authenticate(GamerLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->email)->first();

        if ($user->email_verified_at === null) {
            return response()->json(['error' => __('frontend.email_not_validate')], 403);
        }

        if (Auth::attempt($credentials)) {

            return response()->json(['name' => Auth::user()->name], 200);
        }

        return response()->json(['error' => __('frontend.login_error')], 404);
    }

    public function validateEmail(User $user)
    {
        $user->update(['email_verified_at' => Carbon::now()]);

        return view('frontend.email-valide');
    }
}
