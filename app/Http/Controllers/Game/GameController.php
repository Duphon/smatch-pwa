<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Game\Game;
use App\Models\Game\GameSlot;
use App\Models\Game\GameResult;
use App\Models\Player\Player;
use App\Models\Elo\EloRank;

use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function show()
    {
        // $games        = Game::all();
        // $gameResults  = GameResult::all();

        // return view('games', [
        //     'games'         => $games, 
        //     'game_results'  => $gameResults
        // ]);
    }

    public function create(Request $request)
    {
        $game_creator = Player::find($request->player_id);

        $game                       = new Game();
        $game->creator_player_id    = $game_creator->id;
        $game->sport_id             = $request->sport_id;
        $game->date                 = $request->date;
        $game->elo_value            = $game_creator->elo->value;
        $rank                       = EloRank::where('sport_id', $game->sport_id)
                                            ->where('min', '<=', $game->elo_value)
                                            ->where('max', '>=', $game->elo_value)
                                            ->first();
        $game->elo_rank_id          = $rank->id;
        $game->save();

        for($i = $request->number_of_players; $i--; $i > 0)
        {
                $slot = new \App\Models\Game\GameSlot;
                $slot->game_id = $game->id;
                if($i == $request->number_of_players)
                {
                    $slot->$game_creator->id;
                } else {
                    $slot->player_id = 0;
                }

                if(($i % 2) != 0)
                {
                    $slot->side = "A";
                } else {
                    $slot->side = "B";
                }
                $slot->save();
        }

        return redirect()->back();
    }

    public function update(Request $request)
    {

    }

    public function delete($game_id)
    {
        $game = Game::find($game_id);
        $game->delete();

        return redirect()->back();
    }

    public function join(Request $request)
    {
        $game = Game::find($request->game_id);
        foreach($game->slots as $slot)
        {
            if(!$slot->player){
                $slot->player_id = Auth::user()->player_id;
            }
        }
    }

    public function quit(Request $request)
    {

    }
}
