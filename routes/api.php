<?php

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use MarcReichel\IGDBLaravel\Models\Game;
use MarcReichel\IGDBLaravel\Models\Genre;
use MarcReichel\IGDBLaravel\Models\Platform;

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
    $type = $request->get('type');
    $value = $request->get('value');
  
    return Cache::remember('api_all_games_' . $type, 3600, function () use ($type, $value) {
        $query = Game::with(['screenshots', 'cover', 'platforms', 'genres'])
            ->where('first_release_date', '<', Carbon::now());
        if ($type !== 'platforms') {
            $query->where('platforms.slug', $value);
        }
        if ($type !== 'genres') {
            $query->where('genres.slug', $value);
        }

        return $query->orderBy('first_release_date', 'desc')->get()->toArray();
    });
});

Route::get('/platforms', function (Request $request) {
    return Cache::remember('api_all_platforms', 3600, function () {
        return Platform::all()->toArray();
    });
});

Route::get('/genres', function (Request $request) {
    return Cache::remember('api_all_genres', 3600, function () {
        return Genre::all()->toArray();
    });
});
