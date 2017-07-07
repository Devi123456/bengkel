<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servis extends Model
{
    protected $table = 'servis';
    protected $primaryKey = 'id_servis';
    protected $fillable = ['nama_barang', 'kode_barang', 'jenis_kendaraan', 'mekanik', 'tanggal', 'no_antrian', 'jam_mulai', 'jam_selesai', 'jumlah_barang', 'harga', 'total'];
}
