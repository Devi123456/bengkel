<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Servis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Carbon\Carbon;
use PDF;

class ServisController extends Controller
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
        return view("sistem.servis", ['service' => Servis::all() ]);
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
        \App\Servis::create([
            'kode_barang' => $request->kode,
            'nama_barang' => $request->nama,
            'jenis_kendaraan' => $request->kendaraan,
            'mekanik' => $request->mekanik,
            'tanggal' => $request->tanggal,
            'no_antrian' => $request->no_antrian,
            'jam_mulai' => $request->mulai,
            'jam_selesai' => $request->selesai,
            'jumlah_barang' => $request->jumlah,
            'harga' => $request->harga,
            'total' => (int)$request->jumlah*(float)$request->harga,
        ]);

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
        $servis = Servis::find($id);

        $servis->kode_barang = $request->kode;
        $servis->nama_barang = $request->nama;
        $servis->jenis_kendaraan = $request->kendaraan;
        $servis->mekanik = $request->mekanik;
        $servis->tanggal = $request->tanggal;
        $servis->no_antrian = $request->no_antrian;
        $servis->jam_mulai = $request->mulai;
        $servis->jam_selesai = $request->selesai;
        $servis->jumlah_barang = $request->jumlah;
        $servis->harga = $request->harga;
        $servis->total = $request->total;

        $servis->save();

        return redirect()->back();
    }


    public function laporanServis()
    {
        if(!empty(request('tanggal1') && request('tanggal2'))) {
            $servis = Servis::whereBetween('tanggal', [request('tanggal1'), request('tanggal2')])->get();

            // $total_servis = 0;
            // $total_harga = 0;
            $total = 0;

            foreach($servis as $ser)
            {
                // $total_servis = $total_servis + $ser->jumlah_barang;
                // $total_harga = $total_harga + $ser->harga;
                $total = $total + $ser->total;
            }

            // dd($total_jual);

            return view('sistem.laporan_servis', ['data_servis' => $servis, 'total' => $total]);
        }

        return view('sistem.laporan_servis');
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
            $servis = Servis::whereBetween('tanggal', [request('tanggal1'), request('tanggal2')])->get();

            $total = 0;

            foreach($servis as $ser)
            {
                $total = $total + $ser->total;
            }
            $data = [
                'data_servis' => $servis, 
                'total' => $total
            ];

            $dompdf = new Dompdf();
            // $dompdf->loadHtml($html);

            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'landscape');
            
            $pdf = PDF::loadView('sistem.laporan_servis_pdf', $data);
            return $pdf->stream('invoice.pdf');
        } else {
            return redirect()->back();
        }
    }


    public function destroy($id)
    {
        $servis = Servis::find($id);

        $servis->delete();

        return redirect()->back();
    }
}
