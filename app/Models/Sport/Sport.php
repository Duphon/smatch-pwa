<?php

namespace App\Models\Sport;

use App\Models\Elo\EloRank;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sport extends Model
{
    use HasFactory;

    protected $table = 'sports';

    public function elo_ranks() : HasMany 
    {
        return $this->hasMany(EloRank::class);
    }
}
