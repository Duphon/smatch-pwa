<?php

namespace App\Models\Game;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Game\GameSlot;
use App\Models\Player\Player;
use App\Models\Sport\Sport;
use App\Models\Elo\EloRank;

use App\Events\Game\GameSaved;
use Illuminate\Notifications\Notifiable;

class Game extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'games';

    protected $dispatchesEvents = [
        'saved' => GameSaved::class
    ];

    public function slots() : HasMany 
    {
        return $this->hasMany(GameSlot::class, 'game_id');
    }

    public function creator() : BelongsTo 
    {
        return $this->belongsTo(Player::class, 'creator_player_id');
    }

    public function sport() : BelongsTo 
    {
        return $this->belongsTo(Sport::class);
    }

    public function rank() : BelongsTo 
    {
        // $elo_value = 0;
        // $n_players = 0;

        // foreach($this->slots as $slot)
        // {
        //     if($slot->player)
        //     {
        //         $elo_value += $slot->player->elo->value;
        //         $n_players++;
        //     }
        // }

        // $elo_value = $elo_value / $n_players;

        // $rank = EloRank::where('sport_id', $this->sport_id)
        //     ->where('min', '<=', $elo_value)
        //     ->where('max', '>=', $elo_value)
        //     ->first();

        // return $rank;
        return $this->belongsTo(EloRank::class, 'elo_rank_id');
        
    }
}
