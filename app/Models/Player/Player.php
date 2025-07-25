<?php

namespace App\Models\Player;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

use App\Models\Elo\Elo; 

class Player extends Model
{
    use HasFactory;

    protected $table = 'players';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'player_type_id' 
    ];

    public function elo() : HasOne
    {
        return $this->hasOne(Elo::class);
    }

    public function type() : HasOne 
    {
        return $this->hasOne(PlayerType::class);
    }
}
