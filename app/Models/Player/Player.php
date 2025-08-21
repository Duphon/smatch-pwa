<?php

namespace App\Models\Player;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

use App\Models\Elo\Elo;
use App\Models\Game\GameSlot;
use App\Models\City;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function slots() : HasMany
    {
        return $this->hasMany(GameSlot::class);
    }

    public function city() : BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
