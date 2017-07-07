<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pembelian;
use App\Suku_cadang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Carbon\Carbon;
use PDF;
// use DB;

class PembelianController extends Controller
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
        return view("sistem.pembelian", ['pembeliana' => Pembelian::all() ]);
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
        // mendapatkan stok di database
        $Suku_cadang = Suku_cadang::where('kd_barang', '=', $request->kode)
                                    ->first();

        if(count($Suku_cadang) == 0)
        {

            $beli = new Pembelian;

            $beli->kode_barang = $request->kode;
            $beli->nama_barang = $request->nama;
            $beli->tanggal_pesan = $request->tanggal;
            $beli->jumlah_barang = $request->jumlah;
            $beli->harga_pokok_beli = $request->harga1;
            $beli->harga_pokok_jual = $request->harga2;
            $beli->status = $request->status;
            $beli->total = (int)$request->jumlah*(float)$request->harga2;

            $beli->save();

        }else if(count($Suku_cadang) > 0){
            (int)$stok_update = (int)$Suku_cadang->stok_barang + (int)$request->jumlah;

            $beli = new Pembelian;

            $beli->kode_barang = $request->kode;
            $beli->nama_barang = $request->nama;
            $beli->tanggal_pesan = $request->tanggal;
            $beli->jumlah_barang = $request->jumlah;
            $beli->harga_pokok_beli = $request->harga1;
            $beli->harga_pokok_jual = $request->harga2;
            $beli->status = $request->status;
            $beli->total = (int)$request->jumlah*(float)$request->harga2;

            $beli->save();
            
            // update stok suku cadang
            $Suku_cadang->stok_barang = $stok_update;
            $Suku_cadang->save();
        }

        return redirect()->back();
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
        $pembelian = Pembelian::find($id);

        // kiri lihat database, kanan lihat name input
        $pembelian->kode_barang = $request->kode;
        $pembelian->nama_barang = $request->nama;
        $pembelian->tanggal_pesan = $request->tanggal;
        $pembelian->jumlah_barang = $request->jumlah;
        $pembelian->harga_pokok_beli = $request->harga1;
        $pembelian->harga_pokok_jual = $request->harga2;
        $pembelian->status = $request->status;
        $pembelian->total = (int)$request->jumlah*(float)$request->harga2;
        $pembelian->save();

        return redirect()->back();
    }

    public function laporanPembelian()
    {
        if(!empty(request('tanggal1') && request('tanggal2'))) {
            $terbeli = Pembelian::whereBetween('tanggal_pesan', [request('tanggal1'), request('tanggal2')])->get();

            $total_beli = 0;
            $total_harga = 0;
            $total = 0;

            foreach($terbeli as $beli)
            {
                $total_beli = $total_beli + $beli->jumlah_barang;
                $total_harga = $total_harga + $beli->harga_pokok_beli;                
                $total = $total + $beli->total;
            }

            // dd($total_jual);

            return view('sistem.laporan_pembelian', [
                'data_beli' => $terbeli, 
                'total_beli' => $total_beli,
                'total_harga' => $total_harga, 
                'total' => $total
            ]);
        }

        return view('sistem.laporan_pembelian');
    }

    public function printPdf($html)
    {
        // dd($html);
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();
    }

    public function coba_print_pdf() {
        if(!empty(request('tanggal1') && request('tanggal2'))) {
            $terbeli = Pembelian::whereBetween('tanggal_pesan', [request('tanggal1'), request('tanggal2')])->get();


            $total_beli = 0;
            // $total_harga = 0;
            $total = 0;

            foreach($terbeli as $beli)
            {
                $total_beli = $total_beli + $beli->jumlah_barang;
                // $total_harga = $total_harga + $beli->harga;
                $total = $total + $beli->total;
            }
            $data = [
                'data_beli' => $terbeli, 
                'total_beli' => $total_beli, 
                // 'total_harga' => $total_harga, 
                'total' => $total
            ];

            $dompdf = new Dompdf();
            // $dompdf->loadHtml($html);

            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'landscape');
            
            $pdf = PDF::loadView('sistem.laporan_pembelian_pdf', $data);
            return $pdf->stream('invoice.pdf');
        } else {
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        $pembelian = Pembelian::find($id);

        $pembelian->delete();

        return redirect()->back();
    }
}
