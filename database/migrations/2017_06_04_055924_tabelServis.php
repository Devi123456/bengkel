<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TabelServis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('servis', function (Blueprint $table) {
                $table->increments('id_servis');
                $table->integer('kode_barang');
                $table->string('nama_barang', 30);
                $table->string('mekanik',30);
                $table->date('tanggal');
                $table->integer('no_antrian');
                $table->time('jam_mulai');
                $table->time('jam_selesai');
                $table->integer('jumlah_barang');
                $table->float('harga');
                $table->float('total');
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
        Schema::dropIfExists('servis');
    }
}
