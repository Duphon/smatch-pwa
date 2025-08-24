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

    public function create(Request $request)
    {
        $game_creator = Player::find($request->player_id);

        $game                       = new Game();
        $game->creator_player_id    = $game_creator->id;
        $game->sport_id             = $request->sport_id;
        $game->date                 = $request->date;
        $game->club_id              = $request->club_id;
        $game->elo_value            = $game_creator->currentSportElo()->value;
        $rank                       = EloRank::where('sport_id', $game->sport_id)
                                            ->where('min', '<=', $game->elo_value)
                                            ->where('max', '>=', $game->elo_value)
                                            ->first();
        $game->elo_rank_id          = $rank->id;
        $game->save();
        
        $team_uuid_a = uniqid();
        $team_uuid_b = uniqid();

        for($i = $request->number_of_players; $i--; $i > 0)
        {
            $slot                   = new \App\Models\Game\GameSlot;
            $slot->game_id          = $game->id;
            $slot->player_id        = $i === 1 ? $game_creator->id : 0;
            $slot->team_identifier  = ($i % 2) != 0 ? $team_uuid_a : $team_uuid_b;
                
            $slot->save();
        }

        return redirect()->back();
    }

    public function update(Request $request)
    {
        // @TODO: notify other players of match updates / deletion
    }

    public function delete(Request $request)
    {
        $game = Game::find($request->game_id);
        foreach($game->slots as $slot)
        {
            $slot->delete();
        }
        $game->delete();

        // @TODO: notify other players of match cancel

        return redirect()->back()->with('message', 'Le Match a bien été supprimé');
    }

    public function join(Request $request)
    {
        $game = Game::find($request->game_id);
        foreach($game->slots as $slot)
        {
            if(!$slot->player)
            {
                $slot->player_id = Auth::user()->player_id;
                $slot->update();
                break;
            }
        }

        return redirect()->back()->with('message', 'Vous avez rejoint le match !');
    }

    public function quit(Request $request)
    {
        $game_slot = GameSlot::find($request->game_slot_id);
        $game_slot->player_id = 0;
        $game_slot->update();

        return redirect()->back()->with('message', 'Vous avez quitté le match');

    }
}
