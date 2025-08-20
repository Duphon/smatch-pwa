<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Game\GameResult;
use App\Models\Game\GameSlot;

class GameResultController extends Controller
{
    public function create(Request $request)
    {
        $player_slot = GameSlot::where('game_id', $request->game_id)
                            ->where('player_id', $request->player_id)
                            ->first();
        
        $other_slot = GameSlot::where('team_identifier', '!=', $player_slot->team_identifier)
                            ->where('game_id', $request->game_id)
                            ->first();

        $result = new GameResult();
        $result->filled_by_player_id    = $request->player_id;
        $result->game_id                = $request->game_id;

        if($request->is_winner === 1) {
            $result->winner_team_identifier = $player_slot->team_identifier;
            $result->loser_team_identifier = $other_slot->team_identifier;
        } else {
            $result->loser_team_identifier = $player_slot->team_identifier;
            $result->winner_team_identifier = $other_slot->team_identifier;
        }

        $result->save();

        return redirect()->back()->with('message', 'Le résultat du match a bien été enregistré');
    }
}
