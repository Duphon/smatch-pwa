<?php

    const K             = 40;
    const DIVIDER       = 400;
    const MULTIPLIER    = 10;

    function getWinnerNewElo(int $winner_elo, int $loser_elo)
    {
        return (int)round($winner_elo += K * (1 - eloFactor($winner_elo) / (eloFactor($winner_elo) + eloFactor($loser_elo))));
    }

    function getLoserNewElo(int $winner_elo, int $loser_elo)
    {
        return (int)round($loser_elo += K * (0 - eloFactor($loser_elo) / (eloFactor($loser_elo) + eloFactor($winner_elo))));
    }

    function eloFactor(int $value) 
    {
        return MULTIPLIER*($value/DIVIDER);
    }

?>