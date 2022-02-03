<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLockBalanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lock_balance', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('withdraw_request_id');
            $table->decimal('value', 4, 2);
            $table->char('status', '1')->default(0);//0 - pending, 1 - approved, 2 - canceled
            $table->foreign('withdraw_request_id')->references('id')->on('withdraw_request');
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
        Schema::dropIfExists('lock_balance');
    }
}
