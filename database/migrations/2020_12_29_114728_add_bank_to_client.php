<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBankToClient extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('bank', 100)->after('phone')->nullable();
            $table->string('type_account', 20)->after('bank')->nullable();
            $table->string('agency', 20)->after('type_account')->nullable();
            $table->string('account', 50)->after('agency')->nullable();
            $table->string('pix', 100)->after('account')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['bank', 'type_account', 'agency', 'account', 'pix']);
        });
    }
}
