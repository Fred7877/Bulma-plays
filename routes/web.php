<?php

use App\Http\Controllers\backend\CommentController;
use App\Http\Controllers\frontend\CommentController as FrontendComment;
use App\Http\Controllers\backend\ModerationController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\frontend\FilterGamesController;
use App\Http\Controllers\frontend\GameController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\LoginController;
use App\Http\Controllers\frontend\LogoutController;
use App\Http\Controllers\frontend\RegisterController;
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
        return redirect(route('home'));
    });

    Route::get('games', [GameController::class, 'index'])->name('games.index');
    Route::get('reset-filter', [GameController::class, 'resetFilter'])->name('reset.filter');
    Route::get('games/{slug}', [GameController::class, 'show'])->name('games.show');

    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('filter-game/{platformSlug}/{platformName}', [FilterGamesController::class, 'index'])->name('filter.game');
});

Route::get('/backend', function () {
    return redirect(route('users.index'));
});

Route::middleware(['auth', 'can:enter backend'])->prefix('backend')->group( function () {
    Route::resource('users', UserController::class);
    Route::resource('comments', CommentController::class);
    Route::post('moderation', [ModerationController::class, 'moderation'])->name('backend.moderation');
});

Route::post('gamers-register', [RegisterController::class, 'create'])->name('gamers.register');
Route::get('gamers-login', [LoginController::class, 'authenticate'])->name('gamers.login');
Route::get('gamers-logout', [LogoutController::class, 'logout'])->name('gamers.logout');

Route::post('comment/create', [FrontendComment::class, 'create'])->name('comments.create');

Auth::routes();
