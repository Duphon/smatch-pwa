<?php

namespace App\Models\Elo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Sport\Sport;

class EloRank extends Model
{
    use HasFactory;

    protected $table = 'elo_ranks';

    public function sport() : BelongsTo 
    {
        return $this->belongsTo(Sport::class, 'sport_id');
    }
}
