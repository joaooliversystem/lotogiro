<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRechargeOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recharge_order', function (Blueprint $table) {
            $table->id();
            $table->uuid('reference');
            $table->bigInteger('user_id');
            $table->decimal('value', 4, 2);
            $table->char('status', '1');//0 - pending, 1 - approved, 2 - canceled, 3 - failure
            $table->text('link');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('recharge_order');
    }
}
