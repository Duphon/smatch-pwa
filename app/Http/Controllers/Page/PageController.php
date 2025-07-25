<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Game\Game;
use App\Models\Game\GameResult;
use App\Models\Sport\Sport;
use App\Models\Elo\Elo;
use App\Models\Player\Player;

use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{

    // Matchmaking margin is 50 @todo: allow user tp update it. 
    public function welcome()
    {
        $player_elo = Auth::user()->player->elo->value;

        $sports     = Sport::all();
        $elos       = Elo::orderBy('sport_id')->get();
        $games      = Game::where('elo_value', '<=', $player_elo + 50)->get();

        return view('welcome', [
            'sports'    => $sports,
            'elos'      => $elos,
            'games'     => $games
        ]);
    }

    public function game()
    {
        $games        = Game::all();
        $gameResults  = GameResult::all();
        $sports = Sport::all();

        return view('games.main', [
            'games'         => $games,
            'game_results'  => $gameResults,
            'sports'        => $sports
        ]);
    }

    public function game_update($game_id)
    {
        $games = Game::all();
        $game = Game::find($game_id);
        $sports = Sport::all();

        return view('games.edit', [
            'games' => $games,
            'game'  => $game,
            'sports' => $sports
        ]);
    }

    public function leaderboard()
    {
            $sports     = Sport::all();
            $players    = Player::all();
            $elos       = Elo::orderBy('sport_id')->get();
            $games      = Game::all();

            return view('leaderboard', [
                'sports'    => $sports,
                'players'   => $players,
                'elos'      => $elos,
                'games'     => $games
            ]);
    }
}
