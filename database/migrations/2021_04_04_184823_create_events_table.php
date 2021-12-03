<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('competitionname');
            $table->string('venue');
            $table->date('date');
            $table->string('eventname');
            $table->integer('program_id');
            $table->unsignedBigInteger("office");
            $table->unsignedBigInteger('penciler');
            $table->string('judge')->default("");
            $table->string("position")->nullable();
            $table->boolean("acitve")->default(1);
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
        Schema::dropIfExists('events');
    }
}
