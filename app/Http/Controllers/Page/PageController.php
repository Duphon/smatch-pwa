<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Game\Game;
use App\Models\Game\GameResult;
use App\Models\Game\GameSlot;
use App\Models\Sport\Sport;
use App\Models\Elo\Elo;
use App\Models\Player\Player;

use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{

    // Matchmaking margin is 50 @todo: allow user tp update it. 
    public function welcome(Request $request)
    {
        $player_elo = Auth::user()->player->elo->value;
        $player_id  = Auth::user()->player->id;

        $sports                 = Sport::all();

        $games_matchmaking      = Game::query()
                                    ->where('elo_value', '<=', $player_elo + 100)
                                    ->orderByDesc('date')
                                    ->whereDoesntHave('slots', function ($query) use ($player_id) {
                                        $query->where('player_id', $player_id);
                                    })
                                    ->when($request->has('search'), function($query) use ($request) {
                                        $query->where('sport_id', $request->sport_id);
                                    })
                                    ->get();

        $games                  = Game::query()
                                    ->where('date', '<', now()) // < should be >
                                    ->orderByDesc('date')
                                    ->whereDoesntHave('slots', function ($query) use ($player_id) {
                                        $query->where('player_id', $player_id);
                                    })
                                    ->when($request->has('search'), function($query) use ($request) {
                                        $query->where('sport_id', $request->sport_id);
                                    })
                                    ->get();


        return view('styled.welcome', [
            'sports'            => $sports,
            'games'             => $games,
            'games_matchmaking' => $games_matchmaking
        ]);
    }

    public function player_games()
    {
        $games_created_by_player    = Game::query()
                                        ->where('creator_player_id',  Auth::user()->player->id)
                                        ->get();
        $game_slots_with_player     = GameSlot::where('player_id', Auth::user()->player->id)->get();
        $gameResults                = GameResult::all();
        $sports                     = Sport::all();

        return view('games.main', [
            'games'         => $games_created_by_player,
            'game_results'  => $gameResults,
            'game_slots'    => $game_slots_with_player,
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

            $player_elos = Elo::where('player_id', Auth::user()->player->id)->get();

            return view('leaderboard', [
                'sports'        => $sports,
                'players'       => $players,
                'player_elos'   => $player_elos,
                'elos'          => $elos,
                'games'         => $games
            ]);
    }

    public function parameters()
    {
        $user   = Auth::user();
        $player = $user->player;

        return view('parameters', [
            'user'      => $user,
            'player'    => $player
        ]);
    }
}
