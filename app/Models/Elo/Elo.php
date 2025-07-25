<?php

namespace App\Models\Elo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Sport\Sport;
use App\Models\Player\Player;

class Elo extends Model
{
    use HasFactory;

    protected $table = 'elos';

    public function sport(): BelongsTo 
    {
        return $this->belongsTo(Sport::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function rank() : BelongsTo 
    {
        return $this->belongsTo(EloRank::class, 'elo_rank_id');
    }
}
