<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Suku_cadang;
use App\VariableSukuCadang;
use Illuminate\Support\Facades\Auth;

class VariableSukuCadangController extends Controller
{
    public function _construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Suku_cadang::leftJoin('variable_barang', 'barang.kd_barang', 'variable_barang.barang_id')->get();

        return view("sistem.variable_suku_cadang", ['barangs' => $barang]);
    }

    public function saveOrUpdate($id, Request $request)
    {
        $variable_suku_cadang = VariableSukuCadang::where('barang_id', $id)->first();

        if($variable_suku_cadang) { //update
            $variable_suku_cadang->penjualan_min = $request->penjualan_min;
            $variable_suku_cadang->penjualan_max = $request->penjualan_max;
            $variable_suku_cadang->stok_min = $request->stok_min;
            $variable_suku_cadang->stok_max = $request->stok_max;
            $variable_suku_cadang->stok_berkurang = $request->stok_berkurang;
            $variable_suku_cadang->stok_bertambah = $request->stok_bertambah;

            $variable_suku_cadang->save();
        } else { // tambah
            $data = [
                'barang_id'         => $id,
                'penjualan_min'     => $request->penjualan_min,
                'penjualan_max'     => $request->penjualan_max,
                'stok_min'          => $request->stok_min,
                'stok_max'          => $request->stok_max,
                'stok_berkurang'    => $request->stok_berkurang,
                'stok_bertambah'    => $request->stok_bertambah,
            ];

            VariableSukuCadang::create($data);
        }

        return redirect()->back();
    }
}
