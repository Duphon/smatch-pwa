<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Elo\EloRank;
use App\Models\Sport\Sport;
use App\Models\Player\Player;

use App\Models\User;
use App\Models\Elo\Elo;
use App\Models\City;
use App\Models\Club;
use DateTime;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $sportsToCreate = ['Badminton', 'Tennis'];

        foreach($sportsToCreate as $sport){
            Sport::factory()->create([
                'name' => $sport,
                'min_number_of_players'  => 2,
                'max_number_of_players'  => 4
            ]);
        }

        $sports = Sport::all();

        $file = fopen(public_path("csv/cities.csv"),"r");
        while (($data = fgetcsv($file, 1000, ",")) !== FALSE){
            $city               = new City();
            $city->name         = $data[1];
            $city->latitude     = explode(",",$data[6])[0];
            $city->longitude    = explode(",", $data[6])[1];
            $city->save();
        }
        fclose($file);

        $clubsToCreate = ['Sport Club', 'MegaClub', 'Breizh Game', 'Bad Bros'];

        foreach($clubsToCreate as $club_name)
        {
            $club = new Club();
            $club->name = $club_name;
            $club->city_id = City::inRandomOrder()->first()->id;
            $club->save();
        }
        

        $rankNames = ['Bronze', 'Silver', 'Gold', 'Platinum'];

        foreach($sports as $sport){
            $minElo = 850;
            $maxElo = 949;

            foreach($rankNames as $rank){
                for($i = 3; $i > 0; $i--) {
                    EloRank::factory()->create([
                        'name'      => $rank.' '.$i,
                        'min'       => $minElo,
                        'max'       => $maxElo,
                        'logo'      => strtolower($sport->name).'_'.strtolower($rank).'_'.$i.'.png',
                        'sport_id'  => $sport->id
                    ]);
                    $minElo += 100;
                    $maxElo += 100;
                }
            }
        }

        foreach($sports as $sport){
            $masterRank = 'Master';
            EloRank::factory()->create([
                'name'      => $masterRank,
                'min'       => 2050,
                'max'       => 10000,
                'logo'      => strtolower($sport->name).'_'.strtolower($masterRank).'.png',
                'sport_id'  => $sport->id
            ]);
        }

        \App\Models\User::factory(20)->create();

        $users = User::all();
        foreach($users as $user)
        {
            $player             = Player::factory()->create();
            $user->player_id    = $player->id;
            $user->update();

            foreach($sports as $sport)
            {
                $r_elo = rand(900, 1800);

                $playerElo              = Elo::factory()->create();
                $playerElo->player_id   = $player->id;
                $playerElo->sport_id    = $sport->id;
                // $playerElo->value       = $r_elo;
                // $playerElo->best        = $r_elo;
                // $playerElo->previous_value = $r_elo;
                $playerElo->elo_rank_id = $this->calculateRank($playerElo);
                $playerElo->update();
            }
        }

        $players = Player::inRandomOrder()->limit(10)->get();
        foreach($players as $player)
        {
            $game = new \App\Models\Game\Game;
            $game->creator_player_id    = $player->id;
            $game->date                 = new DateTime('now');
            $game->sport_id             = Sport::inRandomOrder()->first()->id;
            $game->elo_value            = $player->currentSportElo()->value;
            $rank                       = EloRank::where('sport_id', $game->sport_id)
                                            ->where('min', '<=', $game->elo_value)
                                            ->where('max', '>=', $game->elo_value)
                                            ->first();
            $game->elo_rank_id          = $rank->id;
            $game->club_id =  Club::inRandomOrder()->first()->id;
            $game->save();

            $team_uuid_a = uniqid();
            $team_uuid_b = uniqid();

            for($i = 4; $i > 0; $i--) {
                $slot = new \App\Models\Game\GameSlot;
                $slot->game_id = $game->id;
                $slot->player_id = 0;
                if(($i % 2) != 0){
                    $slot->team_identifier = $team_uuid_a;
                } else {
                    $slot->team_identifier = $team_uuid_b;
                }
                $slot->save();
            }
        }

        $games = \App\Models\Game\Game::all();
        foreach($games as $game) {
            $slot = $game->slots->first();
            $slot->player_id = $game->creator_player_id;
            $slot->update();
        }


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }

    public function calculateRank($playerElo)
    {
        $rank = EloRank::where('sport_id', $playerElo->sport_id)
            ->where('min', '<=', $playerElo->value)
            ->where('max', '>=', $playerElo->value)
            ->first();

        return $rank->id;
    }
}
