<?php

use App\Http\Controllers\backend\CommentController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\frontend\AjaxController;
use App\Http\Controllers\frontend\CommentController as FrontendComment;
use App\Http\Controllers\backend\ModerationController;
use App\Http\Controllers\frontend\CustomGameController;
use App\Http\Controllers\backend\CustomGameController as BackendCustomGameController;
use App\Http\Controllers\frontend\FilterGamesController;
use App\Http\Controllers\frontend\GameController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\LoginController;
use App\Http\Controllers\frontend\LogoutController;
use App\Http\Controllers\frontend\RegisterController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Http\Request;

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


// FRONTEND
Route::group([
    'prefix' => LaravelLocalization::setLocale()
], function () {
    Session::put('locale', LaravelLocalization::getCurrentLocale());

    Route::get('/', function () {
        return redirect(route('home'));
    });
    Route::get('games', [GameController::class, 'index'])->name('games.index');
    Route::get('games/homemade', [CustomGameController::class, 'index'])->name('homemade.games.index');
    Route::get('reset-filter', [GameController::class, 'resetFilter'])->name('reset.filter');
    Route::get('games/{slug}', [GameController::class, 'show'])->name('games.show');
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('filter-game/{platformSlug}/{platformName}', [FilterGamesController::class, 'index'])->name('filter.game');
    Route::resource('custom-game', CustomGameController::class)->except('show')->middleware('auth.frontend');

    Route::get('custom-game/user/list', [CustomGameController::class, 'list'])->name('list.custom-games.user')->middleware('auth.frontend');
    Route::get('comments', [FrontendComment::class, 'index'])->name('comments.user');
    Route::get('comments/{comment}/edit', [FrontendComment::class, 'edit'])->name('comments.user.edit');
    Route::put('comments/{comment}', [FrontendComment::class, 'update'])->name('comments.user.update');

    Route::get('custom-game/{slug}', [CustomGameController::class, 'show'])->name('custom-game.show');
});

// BACKEND
Route::get('/backend', function () {
    return redirect(route('users.index'));
});

Route::middleware(['auth', 'can:enter backend'])->prefix('backend')->group(function () {
    Route::resource('users', UserController::class);

    Route::get('comments/edit/{comment}', [CommentController::class, 'edit'])->name('comments.edit');
    Route::post('comments/update/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::get('comments/{type}', [CommentController::class, 'index'])->name('comments.index');

    Route::post('moderation', [ModerationController::class, 'moderation'])->name('backend.moderation');
    Route::resource('custom-games', BackendCustomGameController::class);
    Route::get('horizon-jobs', function(){
        return view('backend.horizon');
    });
});

Route::post('gamers-register', [RegisterController::class, 'create'])->name('gamers.register');
Route::get('gamers-login', [LoginController::class, 'authenticate'])->name('gamers.login');
Route::get('gamers-logout', [LogoutController::class, 'logout'])->name('gamers.logout');
Route::post('comment/create', [FrontendComment::class, 'create'])->name('comments.create');
Route::get('get-user', [AjaxController::class, 'getUser'])->name('ajax.get.user');
Route::get('get-comments-user', [AjaxController::class, 'getCommentsUser'])->name('ajax.user.comments');

Route::get('/email-validation/{user}', [LoginController::class, 'validateEmail'])->name('email.validation')->middleware('signed');

Auth::routes();
