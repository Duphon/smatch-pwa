<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use App\Models\Game\GameSlot;
use Illuminate\Http\Request;

class GameSlotController extends Controller
{
    public function show()
    {

    }

    public function create(Request $request)
    {
        
    }

    public function update(Request $request)
    {
        $slot               = GameSlot::find($request->game_slot_id);
        $slot->player_id    = $request->player_id;
        $slot->update();

        return redirect()->back()->with('message', 'Vous avez rejoint le match !');
    }

    public function join(Request $request)
    {
        $slot               = GameSlot::find($request->game_slot_id);
        $slot->player_id    = $request->player_id;
        $slot->update(); 

        return redirect()->back()->with('message', 'Vous avez rejoint le match !');
    }
}
