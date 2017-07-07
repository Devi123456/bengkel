<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VariableSukuCadang extends Model
{
    protected $table = 'variable_barang';
    protected $fillable = ['barang_id', 'penjualan_min', 'penjualan_max', 'stok_min', 'stok_max', 'stok_berkurang', 'stok_bertambah'];
    public $timestamps = false;
}
