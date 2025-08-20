<?php

namespace App\Models\Game;

use App\Events\GameIsOver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameResult extends Model
{
    use HasFactory;

    protected $dispatchesEvents = [
        'created' => GameIsOver::class
    ];

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
}
