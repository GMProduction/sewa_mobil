<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable(true);
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('harga_id')->unsigned()->nullable(true);
            $table->foreign('harga_id')->references('id')->on('master_hargas');
            $table->integer('total');
            $table->dateTime('tanggal_pinjam');
            $table->dateTime('tanggal_kembali')->default(null)->nullable(true);
            $table->tinyInteger('status');
            $table->tinyInteger('status_pembayaran');
            $table->text('image')->default(null)->nullable(true);
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
        Schema::dropIfExists('transaksis');
    }
}
