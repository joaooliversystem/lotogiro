<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterHashIdToGames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropForeign(['hash_game_id']);
            $table->dropColumn('hash_game_id');
            $table->foreignId('bet_id')->nullable()->after('prize_payment')->constrained('bets')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropForeign(['bet_id']);
            $table->dropColumn('bet_id');
            $table->foreignId('hash_game_id')->nullable()->after('prize_payment')->constrained('hash_games')->onDelete('restrict');
        });
    }
}
