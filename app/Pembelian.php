<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'pembelian';
    protected $primaryKey = 'id_pembelian';
    protected $fillable = ['nama_barang', 'kode_barang', 'tanggal_pesan','jumlah_barang ', 'harga_pokok_beli', 'harga_pokok_jual', 'status', 'total'];

}
