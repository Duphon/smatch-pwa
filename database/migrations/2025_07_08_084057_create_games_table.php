<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Player\Player;
use App\Models\Sport\Sport;
use App\Models\Elo\EloRank;
use App\Models\Club;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Player::class, 'creator_player_id');
            $table->foreignIdFor(Sport::class);
            $table->foreignIdFor(EloRank::class);
            $table->foreignIdFor(Club::class);
            $table->integer('elo_value');
            $table->dateTime('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
};
