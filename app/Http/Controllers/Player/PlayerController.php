<?php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Player\Player;
use App\Models\Player\PlayerType;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

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
        $user = User::findOrFail($request->user_id);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->update();

        $player = $user->player;
        $player->name = $request->player_name;
        $player->update();

        return redirect()->back()->with('message', 'Vos informations ont bien été mises à jour.');
    }
}
