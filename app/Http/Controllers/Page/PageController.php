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
use App\Models\City;

use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{

    // Matchmaking margin is 50 @todo: allow user tp update it. 
    public function welcome(Request $request)
    {
        $player_id  = Auth::user()->player->id;
        $player_favorite_sport_id = Auth::user()->player->favorite_sport_id;
        $player_elo = Auth::user()->player->elos->where('sport_id', $player_favorite_sport_id)->first()->value;

        $sports                 = Sport::all();

        $games_matchmaking      = Game::query()
                                    ->where(function($query) use ($player_elo) {
                                        $query
                                            ->where('elo_value', '<=', $player_elo + 100)
                                            ->where('elo_value', '>', $player_elo - 100);
                                    })
                                    ->whereDoesntHave('slots', function ($query) use ($player_id) {
                                        $query->where('player_id', $player_id);
                                    })
                                    ->where('sport_id', $player_favorite_sport_id)
                                    ->orderByDesc('date')
                                    ->get();

        $games                  = Game::query()
                                    ->where('date', '<', now()) // < should be >
                                    ->orderByDesc('date')
                                    ->whereDoesntHave('slots', function ($query) use ($player_id) {
                                        $query->where('player_id', $player_id);
                                    })
                                    ->where('sport_id', $player_favorite_sport_id)
                                    ->get();


        return view('welcome', [
            'sports'            => $sports,
            'games'             => $games,
            'games_matchmaking' => $games_matchmaking
        ]);
    }

    public function player_games()
    {
        $player             = Auth::user()->player;
        $favorite_sport_id  = $player->favorite_sport_id;

        // $games_created_by_player    = Game::query()
        //                                 ->where('creator_player_id',  $player->id)
        //                                 ->where('sport_id', $player->favorite_sport_id)
        //                                 ->get();

        $player_slots               = GameSlot::where('player_id', $player->id)
                                        ->whereHas('game', function($query) use ($favorite_sport_id) {
                                            $query->where('sport_id', $favorite_sport_id)
                                                ->whereDoesntHave('result');;
                                        })->get();

        $player_slots_played        = GameSlot::where('player_id', $player->id)
                                        ->whereHas('game', function($query) use ($favorite_sport_id) {
                                            $query->where('sport_id', $favorite_sport_id)
                                                  ->whereHas('result');
                                        })->get();
        
        $gameResults                = GameResult::all();
        $sports                     = Sport::all();
        $player_favorite_sport      = Sport::find($favorite_sport_id);

        return view('games.main', [
            'game_results'          => $gameResults,
            'game_slots_next'       => $player_slots,
            'game_slots_played'     => $player_slots_played,
            'sports'                => $sports,
            'player_favorite_sport' => $player_favorite_sport
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
            $player = Auth::user()->player;

            $players    = Player::all();
            $elos       = Elo::where('sport_id', $player->favorite_sport_id)->get();
            $player_elo = Elo::where('player_id', $player->id)->get();

            $games      = Game::all();
            $sports     = Sport::all();

            return view('leaderboard', [
                'players'       => $players,
                'player_elo'    => $player_elo,
                'elos'          => $elos,
                'games'         => $games,
                'sports'        => $sports
            ]);
    }

    public function parameters()
    {
        $sports = Sport::all();
        $user   = Auth::user();
        $cities = City::all();
        $player = $user->player;

        return view('parameters', [
            'user'      => $user,
            'player'    => $player,
            'sports'    => $sports,
            'cities'    => $cities
        ]);
    }
}
