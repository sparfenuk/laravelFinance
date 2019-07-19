<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description' , 1024);
            $table->enum('once_per',['hour' , 'day' , 'week', '2weeks', '4weeks' , 'month', 'year']);
            $table->bigInteger('income');
            $table->integer('user_id');
            $table->integer('wallet_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incomes');
    }
}
