<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Player\Player;
use App\Models\Game\GameSlot;
use App\Models\Game\Game;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_results', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Player::class, 'filled_by_player_id');
            $table->foreignIdFor(Game::class, 'game_id');
            $table->string('winner_team_identifier');
            $table->string('loser_team_identifier');
            $table->string('test')->nullable();
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
        Schema::dropIfExists('game_results');
    }
};
