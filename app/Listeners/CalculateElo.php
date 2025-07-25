<?php

namespace App\Listeners;

use App\Events\GameIsOver;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\Team\Team;

class CalculateElo
{
    // Echecs : facteur K à 40 chez les débutants et 10 chez les pros
    const K             = 40;
    const DIVIDER       = 400;
    const MULTIPLIER    = 10;

    public function handle(GameIsOver $event): void
    {
        // $game = $event->game;

        // $winner_results   = $game->results()->where('win', true)->first();
        // $loser_results   = $game->results()->where('win', false)->first();

        // $winner_team_elo    = $this->getTeamElo($winner_result->team);
        // $loser_team_elo     = $this->getTeamElo($loser_result->team);

        // foreach($winner_result->team->players as $player) 
        // {
        //     $elo            = $player->elo;
        //     $elo->current   = $this->getWinnerNewElo($elo->current, $loser_team_elo);
        //     $elo->update();
        // }

        // foreach($loser_result->team->players as $player) 
        // {
        //     $elo            = $player->elo;
        //     $elo->current   = $this->getLoserNewElo($elo->current, $winner_team_elo);            
        //     $elo->update();
        // }
    }

    // public function getTeamElo(Team $team)
    // {
    //     $total = array_sum($team->players->pluck('elo.current')->toArray());

    //     return $total / $team->players()->count();
    // }

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