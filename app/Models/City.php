<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Club;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';

    public function clubs() : HasMany
    {
        return $this->hasMany(Club::class);
    }
}
