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
        $elo = Elo::find($request->elo_id);
        $elo_value = ($request->elo_estimation) * 50 + 900;

        $elo->value             = $elo_value;
        $elo->previous_value    = $elo_value;
        $elo->best              = $elo_value;

        $rank = EloRank::where('sport_id', $elo->sport_id)
            ->where('min', '<=', $elo_value)
            ->where('max', '>=', $elo_value)
            ->first();

        $elo->elo_rank_id = $rank->id;
        $elo->update();

        return redirect()->back()->with('message', 'Vous pouvez désormais choisir des matchs ! Amusez-vous bien !');
    }
}
