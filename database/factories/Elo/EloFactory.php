<?php

namespace Database\Factories\Elo;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Elo\Elo>
 */
class EloFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $random = rand(850, 2049);

        return [
            'sport_id'      => 0,
            'player_id'     => 0,
            'elo_rank_id'   => 0, 
            'value'         => $random,
            'previous_value'=> $random + rand(-50, 50),
            'best'          => $random, 
        ];
    }
}
