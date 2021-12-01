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
            $table->string('versenynev');
            $table->string('versenyszamnev');
            $table->integer('program_id');
            $table->unsignedBigInteger("iroda");
            $table->unsignedBigInteger('irnok');
            $table->string('biro')->default("");
            $table->string("pozicio")->nullable();
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
