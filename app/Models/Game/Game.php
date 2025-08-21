<?php

namespace App\Models\Game;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

use App\Models\Game\GameSlot;
use App\Models\Player\Player;
use App\Models\Sport\Sport;
use App\Models\Elo\EloRank;
use App\Models\Club;

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
        return $this->hasMany(GameSlot::class);
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
        return $this->belongsTo(EloRank::class, 'elo_rank_id');   
    }

    public function result() : HasOne 
    {
        return $this->hasOne(GameResult::class);
    }

    public function club() : BelongsTo
    {
        return $this->belongsTo(Club::class, 'club_id');
    }
}
