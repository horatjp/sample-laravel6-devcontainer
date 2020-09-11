<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManagerLoginHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manager_login_history', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->bigInteger('manager_id')->unsigned();
            $table->foreign('manager_id')->references('id')->on('manager')->onDelete('cascade');

            $table->string('ip_address');
            $table->string('user_agent');
            $table->dateTime('created_at')->unique();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manager_login_history');
    }
}
