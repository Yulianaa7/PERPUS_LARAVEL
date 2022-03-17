<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengembalianBukuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengembalian_buku', function (Blueprint $table) {
            $table->bigIncrements('id_pengembalian_buku');
            $table->date('tanggal_pengembalian');
            $table->integer('denda');
            $table->unsignedBigInteger('id_peminjaman_buku');

            $table->foreign('id_peminjaman_buku')->references('id_peminjaman_buku')->on('peminjaman_buku');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengembalian_buku');
    }
}
