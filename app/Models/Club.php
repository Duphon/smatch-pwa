<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Game\Game;
use App\Models\City;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Club extends Model
{
    use HasFactory;

    protected $table = 'clubs';

    protected $fillable = [
        'name', 
        'city_id'
    ];

    public function games() : HasMany
    {
        return $this->hasMany(Game::class);
    }

    public function city() : BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }


}
