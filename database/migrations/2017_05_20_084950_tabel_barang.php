<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TabelBarang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('barang', function (Blueprint $table) {
        //     $table->increments('id_barang');
        //     $table->string('nama_barang', 30);
        //     $table->string('kd_barang', 30);
        //     $table->integer('stok_barang');
        //     $table->float('harga');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::drop('barang');
    }
}
