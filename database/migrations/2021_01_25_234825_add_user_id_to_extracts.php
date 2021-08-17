<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToExtracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('extracts', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('description')->constrained('users')->onDelete('restrict');
            $table->foreignId('client_id')->nullable()->after('user_id')->constrained('clients')->onDelete('restrict');
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
            $table->dropColumn(['user_id', 'client_id']);
        });
    }
}
