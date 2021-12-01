<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('event_id');
            $table->integer('program_id');
            $table->string('lovas_id');
            $table->string('lovas_nev');
            $table->string('lo_id');
            $table->string('lo_nev');
            $table->string('egyesulet');
            $table->string('kategoria');
            $table->json('ertekeles')->nullable();
            $table->float('pont')->default(0);
            $table->float('szazalek')->default(0);
            $table->integer('helyezes')->default(0);
            $table->boolean('kitoltve')->default(0);
            $table->boolean('publikus')->default(1);
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
        Schema::dropIfExists('results');
    }
}
