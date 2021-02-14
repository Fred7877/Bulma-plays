<?php

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use MarcReichel\IGDBLaravel\Models\Game;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/games', function (Request $request) {
    return Cache::remember('api_all_games', 3600, function () {
        return Game::with(['screenshots', 'cover'])
            ->where('first_release_date', '<', Carbon::now())
            ->orderBy('first_release_date', 'desc')->get()->toArray();
    });
});
