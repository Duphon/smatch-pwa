<?php

namespace App\Listeners;

use App\Events\Game\GameSlotUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateGameElo
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\GameSlotUpdated  $event
     * @return void
     */
    public function handle(GameSlotUpdated $event)
    {
        $game_slot  = $event->slot;
        $game       = $game_slot->game;

        $total_elo = 0;
        $number_of_slots_filled = 0;

        foreach($game->slots as $slot)
        {
            if($slot->player){
                $total_elo += $slot->player->elo->value;
                $number_of_slots_filled ++;
            }
        }

        $game->elo_value = ($total_elo / $number_of_slots_filled);
        $game->save();
    }
}
