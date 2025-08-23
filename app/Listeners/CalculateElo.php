<?php

namespace App\Listeners;

use App\Events\GameIsOver;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\Team\Team;
use App\Models\Game\GameSlot;

class CalculateElo
{
    // Echecs : facteur K à 40 chez les débutants et 10 chez les pros
    const K             = 40;
    const DIVIDER       = 400;
    const MULTIPLIER    = 10;

    public function handle(GameIsOver $event): void
    {
        $result         = $event->game_result;
        $result->test   = "This has been updated";
        $result->update();

        $loser_team_slots     = GameSlot::where('team_identifier', $result->loser_team_identifier)->get();
        $winner_team_slots    = GameSlot::where('team_identifier', $result->winner_team_identifier)->get();

        $game       = $result->game;
        $game_elo   = $game->elo_value;

        foreach($loser_team_slots as $slot)
        {
            if($slot->player){  
                $elo            = $slot->player->elos->where('sport_id', $slot->player->favorite_sport_id)->first();
                $elo->value     = $this->getWinnerNewElo($elo->value, $game_elo);
                $elo->update();
            }
        }

        foreach($winner_team_slots as $slot)
        {
            if($slot->player){
                $elo            = $slot->player->elos->where('sport_id', $slot->player->favorite_sport_id)->first();
                $elo->value     = $this->getLoserNewElo($elo->value, $game_elo);
                $elo->update();
            }
        }
    }

    public function getWinnerNewElo(int $winner_elo, int $loser_elo)
    {
        return ($winner_elo += self::K * (1 - $this->eloFactor($winner_elo) / ($this->eloFactor($winner_elo) + $this->eloFactor($loser_elo))));
    }

    public function getLoserNewElo(int $loser_elo, int $winner_elo)
    {
        return ($loser_elo += self::K * (0 - $this->eloFactor($loser_elo) / ($this->eloFactor($loser_elo) + $this->eloFactor($winner_elo))));
    }

    public function eloFactor(int $value) 
    {
        return self::MULTIPLIER*($value/self::DIVIDER);
    }
}