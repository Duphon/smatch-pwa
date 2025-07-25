<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Sport\Sport;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elo_ranks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('min');
            $table->integer('max');
            $table->string('logo');
            $table->foreignIdFor(Sport::class);
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
        Schema::dropIfExists('elo_ranks');
    }
};
