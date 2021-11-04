<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterHargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_hargas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mobil_id')->unsigned()->nullable(true);
            $table->foreign('mobil_id')->references('id')->on('master_mobils');
            $table->integer('duration');
            $table->integer('harga');
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
        Schema::dropIfExists('master_hargas');
    }
}
