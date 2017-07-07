<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
     protected $table = 'penjualan';
     protected $primaryKey = 'id_penjualan';
     protected $fillable = ['nama_barang', 'kode_barang', 'tanggal_pesan', 'tanggal_tersedia', 'jumlah_barang', 'harga', 'total'];
}
