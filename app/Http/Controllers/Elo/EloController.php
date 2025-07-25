<?php

namespace App\Http\Controllers\Elo;

use App\Http\Controllers\Controller;
use App\Listeners\CalculateElo;
use Illuminate\Http\Request;

use App\Models\Elo\Elo;
use App\Models\Elo\EloRank;

use App\Models\Sport\Sport;

class EloController extends Controller
{
    public function show()
    {
        $elos        = Elo::orderBy('value', 'DESC')->get();

        return $elos;
    }

    public function create(Request $request)
    {

    }

    public function update(Request $request)
    {
        $elo_winner = Elo::find($request->winner_elo_id);
        $elo_loser  = Elo::find($request->loser_elo_id);

        $new_elo_winner = getWinnerNewElo($elo_winner->value, $elo_loser->value);
        $new_elo_loser  = getLoserNewElo($elo_winner->value, $elo_loser->value);
        
        $new_winner_rank = EloRank::where('sport_id', $elo_winner->sport_id)
            ->where('min', '<=', $new_elo_winner)
            ->where('max', '>=', $new_elo_winner)
            ->first();

        $new_loser_rank = EloRank::where('sport_id', $elo_loser->sport_id)
            ->where('min', '<=', $new_elo_loser)
            ->where('max', '>=', $new_elo_loser)
            ->first();

        $elo_winner->elo_rank_id    = $new_winner_rank->id;
        if($new_elo_winner > $elo_winner->value) {
            $elo_winner->best = $new_elo_winner;
        }
        $elo_winner->previous_value = $elo_winner->value;
        $elo_winner->value          = $new_elo_winner;
        $elo_winner->update();

        $elo_loser->elo_rank_id     = $new_loser_rank->id;
        if($new_elo_loser > $elo_loser->value) {
            $elo_loser->best = $new_elo_loser;
        }
        $elo_loser->previous_value  = $elo_loser->value;
        $elo_loser->value           = $new_elo_loser;
        $elo_loser->update();

        return redirect()->back();
    }
}
