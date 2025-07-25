<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Sport\Sport;
use App\Models\Player\Player;
Use App\Models\Elo\EloRank;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elos', function (Blueprint $table) {
            $table->id();
            $table->integer('value')->default(1000);
            $table->integer('previous_value')->default(1000);
            $table->integer('best')->default(1000);
            $table->foreignIdFor(Sport::class);
            $table->foreignIdFor(Player::class);
            $table->foreignIdFor(EloRank::class);
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
        Schema::dropIfExists('elos');
    }
};
