<?php

namespace App\Models\Game;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Game\Game;
use App\Models\Player\Player;

use App\Events\Game\GameSlotUpdated;
use Illuminate\Notifications\Notifiable;

class GameSlot extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'game_slots';

    protected $dispatchesEvents = [
        'updated' => GameSlotUpdated::class
    ];

    public function game() : BelongsTo 
    {
        return $this->belongsTo(Game::class);
    }

    public function player() : BelongsTo 
    {
        return $this->belongsTo(Player::class);
    }
}
