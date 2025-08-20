<?php

use Illuminate\Support\Facades\Route;

use App\Models\Elo\Elo;
use App\Models\Elo\EloRank;
use App\Models\Game\Game;
use App\Models\Player\Player;
use App\Models\Sport\Sport;

use App\Http\Controllers\Player\PlayerController;
use App\Http\Controllers\Elo\EloController;
use App\Http\Controllers\Game\GameSlotController;
use App\Http\Controllers\Game\GameController;
use App\Http\Controllers\Game\GameResultController;
use App\Http\Controllers\Page\PageController;

use Illuminate\Support\Facades\Auth;

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

Route::group(['middleware' => 'auth'], function() {

    Route::get('/home',             [PageController::class, 'welcome'])->name('page.welcome');
    Route::get('/leaderboard',      [PageController::class, 'leaderboard'])->name('page.leaderboard');
    Route::get('/parameters',       [PageController::class, 'parameters'])->name('page.parameters');
    Route::get('/game',             [PageController::class, 'player_games'])->name('page.games');
    Route::get('/game/{$game_id}',  [PageController::class, 'game_update'])->name('page.game.update');

    Route::post('game/create',  [GameController::class, 'create'])->name('game.create');
    Route::post('game/update',  [GameController::class, 'update'])->name('game.update');
    Route::post('game/delete',  [GameController::class, 'delete'])->name('game.delete');
    Route::post('game/join',    [GameController::class, 'join'])->name('game.join');
    Route::post('game/quit',    [GameController::class, 'quit'])->name('game.quit');

    Route::get('/player',           [PlayerController::class, 'show'])->name('player.show');
    Route::post('/player/create',   [PlayerController::class, 'create'])->name('player.create');
    Route::post('/player/update',   [PlayerController::class, 'update'])->name('player.update');

    Route::post('/game/result/create', [GameResultController::class, 'create'])->name('game.result.create');

    Route::prefix('elo')->group(function () {
        Route::get('/', [EloController::class, 'show']);
        Route::post('/create', [EloController::class, 'create']);
        Route::post('/update', [EloController::class, 'update']); // replace post with put and remove /update name
    });

    Route::prefix('/slot')->group(function() {
        Route::get('/', [GameSlotController::class, 'show']);
        Route::post('/create', [GameSlotController::class, 'create']);
        Route::post('/update', [GameSlotController::class, 'update'])->name('game.slot.update');
        Route::post('/join', [GameSlotController::class, 'join'])->name('game.slot.join');
    });

});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
