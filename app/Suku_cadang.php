<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suku_cadang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $fillable = ['nama_barang', 'kd_barang', 'stok_barang', 'harga'];
}
