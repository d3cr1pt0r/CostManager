<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Traffic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traffic', function (Blueprint $table) {
            $table->increments('id');
            $table->foreign('traffic_type_id')->references('id')->on('traffic_type');
            $table->decimal('amount', 5, 2);
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('traffic');
    }
}
