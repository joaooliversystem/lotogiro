<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeGameToExtracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('extracts', function (Blueprint $table) {
            $table->foreignId('type_game_id')->nullable()->after('client_id')->constrained('type_games')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('extracts', function (Blueprint $table) {
            $table->dropColumn('type_game_id');
        });
    }
}
