<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Player\Player;
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
        Schema::create('game_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Player::class);
            $table->foreignIdFor(Game::class);
            $table->string('team_identifier');
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
        Schema::dropIfExists('game_slots');
    }
};
