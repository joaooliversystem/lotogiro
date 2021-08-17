<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id()->startingValue(1001);
            $table->foreignId('client_id')->constrained('clients')->onDelete('restrict');
            $table->foreignId('type_game_id')->constrained('type_games')->onDelete('restrict');
            $table->foreignId('type_game_value_id')->constrained('type_game_values')->onDelete('restrict');
            $table->string('numbers');
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
}
