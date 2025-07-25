<?php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Player\Player;
use App\Models\Player\PlayerType;

class PlayerController extends Controller
{
    public function show()
    {
        $players        = Player::all();
        $playerTypes    = PlayerType::all();

        return view('players', [
            'players'       => $players, 
            'player_types'  => $playerTypes
        ]);
    }

    public function create(Request $request)
    {
        
    }

    public function update(Request $request)
    {

    }
}
