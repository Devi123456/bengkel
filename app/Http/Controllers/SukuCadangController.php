<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Suku_cadang;
use Illuminate\Support\Facades\Auth;

class sukuCadangController extends Controller
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
        return view("sistem.suku_cadang", ['barangs' => Suku_cadang::all() ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cek_nama = Suku_cadang::where('nama_barang', '=', $request->nama)
                                ->orWhere('kd_barang', '=', $request->Kode)
                                ->select('kd_barang','nama_barang')
                                ->first();

                                    // dd($cek_nama);

        if( count($cek_nama) > 0 ){
            if( $request->Kode == $cek_nama->kd_barang && $request->nama == $cek_nama->nama_barang ){

                $tambah = Suku_cadang::where('nama_barang', '=', $request->nama)
                                        ->where('kd_barang', '=', $request->Kode)
                                        ->increment('stok_barang', $request->Stok);

                return redirect()->back();

            }else if($request->Kode != $cek_nama->kd_barang && $request->nama == $cek_nama->nama_barang){
                
                return redirect()->back()->with('error', 'nama barang sudah ada!!');

            }else if($request->Kode == $cek_nama->kd_barang && $request->nama != $cek_nama->nama_barang){

                return redirect()->back()->with('error', 'kode sudah terpakai!!');
            }
        }else{
            \App\Suku_cadang::create([
                'kd_barang' => $request->Kode,
                'nama_barang' => $request->nama,
                'stok_barang' => $request->Stok,
                'harga' => $request->harga,
            ]);

            return redirect()->back();
        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $suku_cadang = Suku_cadang::find($id);

        $suku_cadang->kd_barang = $request->Kode;
        $suku_cadang->nama_barang = $request->nama;
        $suku_cadang->stok_barang = $request->Stok;
        $suku_cadang->harga = $request->harga;

        $suku_cadang->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $suku_cadang = Suku_cadang::find($id);

        $suku_cadang->delete();

        return redirect()->back();
    }

    public function CekDaftarBarang(Request $request, $nama_barang){
        $nama = $request->input('nama');

        $results = array();

        $suku_cadang = Suku_cadang::where('nama_barang', 'LIKE', '%'.$nama_barang.'%')
                                    // ->pluck('nama_barang')
                                    ->get();

        foreach($suku_cadang as $query){
            $results[] = ['nama' => $query->nama_barang ];
        }

        return response()->json($results);
    }

    public function CekSukuCadang($nama_barang)
    {
        $kode_barang = Suku_cadang::where('nama_barang', 'LIKE', '%'.$nama_barang.'%')
                                    ->pluck('kd_barang')
                                    ->first();

        $jumlah_barang = Suku_cadang::where('nama_barang', 'LIKE', '%'.$nama_barang.'%')
                                    ->pluck('stok_barang')
                                    ->first();

        $harga_jual = Suku_cadang::where('nama_barang', 'LIKE', '%'.$nama_barang.'%')
                                    ->pluck('harga')
                                    ->first();

        return response()->json([
            'kd_barang' => $kode_barang,
            'jumlah' => $jumlah_barang,
            'harga_jual' => $harga_jual
        ]);
    }
}
