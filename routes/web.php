<?php

use App\Http\Controllers\backend\CommentController;
use App\Http\Controllers\backend\ModerationController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\frontend\GameController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'namespace' => 'frontend',
    'prefix' => LaravelLocalization::setLocale()
], function () {
    Route::get('/', function () {
        return redirect(route('games.index'));
    });

    Route::get('games', [GameController::class, 'index'])->name('games.index');
    Route::get('reset-filter', [GameController::class, 'resetFilter'])->name('reset.filter');
    Route::get('games/{slug}', [GameController::class, 'show'])->name('games.show');
});

Route::get('/backend', function () {
    return redirect(route('users.index'));
});

Route::group([
    'prefix' => 'backend'
], function () {
    Route::resource('users', UserController::class);
    Route::resource('comments', CommentController::class);
    Route::post('moderation', [ModerationController::class, 'moderation'])->name('backend.moderation');
});

Auth::routes();
