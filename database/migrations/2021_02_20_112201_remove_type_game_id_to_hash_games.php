<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTypeGameIdToHashGames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hash_games', function (Blueprint $table) {
            $table->dropForeign(['type_game_id']);
            $table->dropColumn('type_game_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hash_games', function (Blueprint $table) {
            $table->foreignId('type_game_id')->nullable()->constrained('type_games')->onDelete('cascade');
        });
    }
}
