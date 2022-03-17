<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailPeminjamanBukuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_peminjaman_buku', function (Blueprint $table) {
            $table->bigIncrements('id_detail');
            $table->integer('qty');
            $table->unsignedBigInteger('id_peminjaman_buku');
            $table->unsignedBigInteger('id_buku');
            $table->foreign('id_peminjaman_buku')->references('id_peminjaman_buku')->on('peminjaman_buku');
            $table->foreign('id_buku')->references('id_buku')->on('buku');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_peminjaman_buku');
    }
}
