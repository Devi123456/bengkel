<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penjualan;
use App\Pembelian;
use App\Suku_cadang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Dompdf\Dompdf;
use Carbon\Carbon;
use PDF;
use DB;

class PenjualanController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("sistem.penjualan", ['penjualana' => Penjualan::all() ]);
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
        $stok_barang = Suku_cadang::where('nama_barang', 'LIKE', '%'.$request->nama.'%')
                                    ->pluck('stok_barang')
                                    ->first();

        if( $request->jumlah > $stok_barang ){

            return back()->with('fail', 'Stok tidak mencukupi');

        }else if( $request->jumlah <= $stok_barang){
            // mendapatkan stok di database
            $Suku_cadang = Suku_cadang::where('kd_barang', $request->kode)
                                        ->first();
            $stok_update = $Suku_cadang->stok_barang - (int)$request->jumlah;

            \App\Penjualan::create([
                'kode_barang' => $request->kode,
                'nama_barang' => $request->nama,
                'tanggal_pesan' => $request->tanggal,
                'tanggal_tersedia' => $request->tanggal1,
                'jumlah_barang' => $request->jumlah,
                'harga' => $request->harga,
                'total' => (int)$request->jumlah*(float)$request->harga,
            ]);

            // update stok suku cadang
            $Suku_cadang->stok_barang = $stok_update;
            $Suku_cadang->save();

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
        $penjualan = Penjualan::find($id);

        $penjualan->kode_barang = $request->kode;
        $penjualan->nama_barang = $request->nama;
        $penjualan->tanggal_pesan = $request->tanggal;
        $penjualan->tanggal_tersedia = $request->tanggal1;
        $penjualan->jumlah_barang = $request->jumlah;
        $penjualan->harga = $request->harga;
        $penjualan->total = (int)$request->jumlah*(float)$request->harga;

        $penjualan->save();

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
        $penjualan = Penjualan::find($id);

        $penjualan->delete();

        return redirect()->back();
    }

    public function getEstimasiBeli()
    {
        $barang = Pembelian::select(
                                'pembelian.kode_barang',
                                'pembelian.nama_barang',
                                DB::raw('SUM(jumlah_barang) AS jumlah_beli'),
                                'variable_barang.penjualan_min',
                                'variable_barang.penjualan_max',
                                'variable_barang.stok_min',
                                'variable_barang.stok_max',
                                'variable_barang.stok_berkurang',
                                'variable_barang.stok_bertambah'
                            )
                            ->join('variable_barang', 'pembelian.kode_barang', 'variable_barang.barang_id')
                            ->groupBy('pembelian.kode_barang');
        
        if(Input::get('from')) {
            $barang = $barang->whereBetween('pembelian.tanggal_pesan', [Input::get('from'), Input::get('to')]);
        } else {
            $barang = $barang->whereBetween('pembelian.tanggal_pesan', [date('Y-m-d'), date('Y-m-d')]);
        }
        
        $barang = $barang->get();

        // dump($barang);

        foreach ($barang as $key => $value) {
                //penjualan
                $penjualan_sedang = round(($value->penjualan_max - $value->penjualan_min) / 2);

                if(! $value->penjualan_min) {
                    $value->estimasi = 'Tak Terhingga';
                    continue;
                }

                $him_penjualan_rendah = 
                    round(($penjualan_sedang - ($value->penjualan_min+1)) / $value->penjualan_min, 2);

                if(! ($penjualan_sedang - $value->penjualan_min)) {
                    $value->estimasi = 'Tak Terhingga';
                    continue;
                }

                $him_penjualan_sedang = 
                    round((($value->penjualan_min+1) - $value->penjualan_min) / ($penjualan_sedang - $value->penjualan_min), 2);

                if(! ($value->penjualan_max)) {
                    $value->estimasi = 'Tak Terhingga';
                    continue;
                }

                $him_penjualan_tinggi = 
                    round((($penjualan_sedang+1) - ($penjualan_sedang)) / ($value->penjualan_max), 2);

                $value->penjualan_rendah = $him_penjualan_rendah;
                $value->penjualan_sedang = $him_penjualan_sedang;
                $value->penjualan_tinggi = $him_penjualan_tinggi;

                //stok
                $stok_sedang = round(($value->stok_max - $value->stok_min) / 2);

                if(! ($value->stok_min)) {
                    $value->estimasi = 'Tak Terhingga';
                    continue;
                }

                $him_stok_rendah = 
                    round(($stok_sedang - ($value->stok_min+1)) / $value->stok_min, 2);

                if(! ($stok_sedang - $value->stok_min)) {
                    $value->estimasi = 'Tak Terhingga';
                    continue;
                }

                $him_stok_sedang = 
                    round((($value->stok_min+1) - $value->stok_min) / ($stok_sedang - $value->stok_min), 2);

                if(! ($value->stok_max)) {
                    $value->estimasi = 'Tak Terhingga';
                    continue;
                }

                $him_stok_tinggi = 
                    round((($stok_sedang+1) - ($stok_sedang)) / ($value->stok_max), 2);

                $value->stok_rendah = $him_stok_rendah;
                $value->stok_sedang = $him_stok_sedang;
                $value->stok_tinggi = $him_stok_tinggi;

                //estimasi            
                $r1 = min($value->penjualan_tinggi, $value->stok_rendah);
                $z1 = 
                    $value->stok_bertambah - min($value->penjualan_tinggi, $value->stok_rendah) * 
                    ($value->stok_bertambah - $value->stok_berkurang);

                $value->r1 = $r1;
                $value->z1 = $z1;

                $r2 = min($value->penjualan_tinggi, $value->stok_sedang);
                $z2 = 
                    $value->stok_bertambah - min($value->penjualan_tinggi, $value->stok_sedang) * 
                    ($value->stok_bertambah - $value->stok_berkurang);

                $value->r2 = $r2;
                $value->z2 = $z2;

                $r3 = min($value->penjualan_tinggi, $value->stok_tinggi);
                $z3 = 
                    $value->stok_bertambah - min($value->penjualan_tinggi, $value->stok_tinggi) * 
                    ($value->stok_bertambah - $value->stok_berkurang);

                $value->r3 = $r3;
                $value->z3 = $z3;

                $r4 = min($value->penjualan_sedang, $value->stok_rendah);
                $z4 = 
                    $value->stok_bertambah - min($value->penjualan_sedang, $value->stok_rendah) * 
                    ($value->stok_bertambah - $value->stok_berkurang);

                $value->r4 = $r4;
                $value->z4 = $z4;

                $r5 = min($value->penjualan_sedang, $value->stok_sedang);
                $z5 = 
                    $value->stok_bertambah - min($value->penjualan_sedang, $value->stok_sedang) * 
                    ($value->stok_bertambah - $value->stok_berkurang);

                $value->r5 = $r5;
                $value->z5 = $z5;

                $r6 = min($value->penjualan_sedang, $value->stok_tinggi);
                $z6 = 
                    $value->stok_berkurang - min($value->penjualan_sedang, $value->stok_tinggi) * 
                    ($value->stok_bertambah - $value->stok_berkurang);

                $value->r6 = $r6;
                $value->z6 = $z6;

                $r7 = min($value->penjualan_rendah, $value->stok_rendah);
                $z7 = 
                    $value->stok_berkurang - min($value->penjualan_rendah, $value->stok_rendah) * 
                    ($value->stok_bertambah - $value->stok_berkurang);

                $value->r7 = $r7;
                $value->z7 = $z7;

                $r8 = min($value->penjualan_rendah, $value->stok_sedang);
                $z8 = 
                    $value->stok_berkurang - min($value->penjualan_rendah, $value->stok_sedang) * 
                    ($value->stok_bertambah - $value->stok_berkurang);

                $value->r8 = $r8;
                $value->z8 = $z8;

                $r9 = min($value->penjualan_rendah, $value->stok_tinggi);
                $z9 = 
                    $value->stok_berkurang - min($value->penjualan_rendah, $value->stok_tinggi) * 
                    ($value->stok_bertambah - $value->stok_berkurang);

                $value->r9 = $r9;
                $value->z9 = $z9;

                $value->atas = ($r1*$z1+$r2*$z2+$r3*$z3+$r4*$z4+$r5*$z5+$r6*$z6+$r7*$z7+$r8*$z8+$r9*$z9);

                $value->bawah = ($r1+$r2+$r3+$r4+$r5+$r6+$r7+$r8+$r9);

                if(! ($r1+$r2+$r3+$r4+$r5+$r6+$r7+$r8+$r9)) {
                    $value->estimasi = 'Tak Terhingga';
                    continue;
                }
                $value->estimasi = 
                    round(($r1*$z1+$r2*$z2+$r3*$z3+$r4*$z4+$r5*$z5+$r6*$z6+$r7*$z7+$r8*$z8+$r9*$z9) / 
                      ($r1+$r2+$r3+$r4+$r5+$r6+$r7+$r8+$r9));
            // dump($value);
        }

        // dump($barang);

        return view("sistem.est_pembelian", ['barangs' => $barang]);
    }

    public function getEstimasi()
    {
        $barang = Penjualan::select(
                                'penjualan.kode_barang',
                                'penjualan.nama_barang',
                                DB::raw('SUM(jumlah_barang) AS jumlah_jual'),
                                'variable_barang.penjualan_min',
                                'variable_barang.penjualan_max',
                                'variable_barang.stok_min',
                                'variable_barang.stok_max',
                                'variable_barang.stok_berkurang',
                                'variable_barang.stok_bertambah'
                            )
                            ->join('variable_barang', 'penjualan.kode_barang', 'variable_barang.barang_id')
                            ->groupBy('penjualan.kode_barang');
        
        if(Input::get('from')) {
            $barang = $barang->whereBetween('penjualan.tanggal_pesan', [Input::get('from'), Input::get('to')]);
        } else {
            $barang = $barang->whereBetween('penjualan.tanggal_pesan', [date('Y-m-d'), date('Y-m-d')]);
        }
        
        $barang = $barang->get();

        // dump($barang);

        foreach ($barang as $key => $value) {
                //penjualan
                $penjualan_sedang = round(($value->penjualan_max - $value->penjualan_min) / 2);

                if(! $value->penjualan_min) {
                    $value->estimasi = 'Tak Terhingga';
                    continue;
                }

                $him_penjualan_rendah = 
                    round(($penjualan_sedang - ($value->penjualan_min+1)) / $value->penjualan_min, 2);

                if(! ($penjualan_sedang - $value->penjualan_min)) {
                    $value->estimasi = 'Tak Terhingga';
                    continue;
                }

                $him_penjualan_sedang = 
                    round((($value->penjualan_min+1) - $value->penjualan_min) / ($penjualan_sedang - $value->penjualan_min), 2);

                if(! ($value->penjualan_max)) {
                    $value->estimasi = 'Tak Terhingga';
                    continue;
                }

                $him_penjualan_tinggi = 
                    round((($penjualan_sedang+1) - ($penjualan_sedang)) / ($value->penjualan_max), 2);

                $value->penjualan_rendah = $him_penjualan_rendah;
                $value->penjualan_sedang = $him_penjualan_sedang;
                $value->penjualan_tinggi = $him_penjualan_tinggi;

                //stok
                $stok_sedang = round(($value->stok_max - $value->stok_min) / 2);

                if(! ($value->stok_min)) {
                    $value->estimasi = 'Tak Terhingga';
                    continue;
                }

                $him_stok_rendah = 
                    round(($stok_sedang - ($value->stok_min+1)) / $value->stok_min, 2);

                if(! ($stok_sedang - $value->stok_min)) {
                    $value->estimasi = 'Tak Terhingga';
                    continue;
                }

                $him_stok_sedang = 
                    round((($value->stok_min+1) - $value->stok_min) / ($stok_sedang - $value->stok_min), 2);

                if(! ($value->stok_max)) {
                    $value->estimasi = 'Tak Terhingga';
                    continue;
                }

                $him_stok_tinggi = 
                    round((($stok_sedang+1) - ($stok_sedang)) / ($value->stok_max), 2);

                $value->stok_rendah = $him_stok_rendah;
                $value->stok_sedang = $him_stok_sedang;
                $value->stok_tinggi = $him_stok_tinggi;

                //estimasi            
                $r1 = min($value->penjualan_tinggi, $value->stok_rendah);
                $z1 = 
                    $value->stok_bertambah - min($value->penjualan_tinggi, $value->stok_rendah) * 
                    ($value->stok_bertambah - $value->stok_berkurang);

                $value->r1 = $r1;
                $value->z1 = $z1;

                $r2 = min($value->penjualan_tinggi, $value->stok_sedang);
                $z2 = 
                    $value->stok_bertambah - min($value->penjualan_tinggi, $value->stok_sedang) * 
                    ($value->stok_bertambah - $value->stok_berkurang);

                $value->r2 = $r2;
                $value->z2 = $z2;

                $r3 = min($value->penjualan_tinggi, $value->stok_tinggi);
                $z3 = 
                    $value->stok_bertambah - min($value->penjualan_tinggi, $value->stok_tinggi) * 
                    ($value->stok_bertambah - $value->stok_berkurang);

                $value->r3 = $r3;
                $value->z3 = $z3;

                $r4 = min($value->penjualan_sedang, $value->stok_rendah);
                $z4 = 
                    $value->stok_bertambah - min($value->penjualan_sedang, $value->stok_rendah) * 
                    ($value->stok_bertambah - $value->stok_berkurang);

                $value->r4 = $r4;
                $value->z4 = $z4;

                $r5 = min($value->penjualan_sedang, $value->stok_sedang);
                $z5 = 
                    $value->stok_bertambah - min($value->penjualan_sedang, $value->stok_sedang) * 
                    ($value->stok_bertambah - $value->stok_berkurang);

                $value->r5 = $r5;
                $value->z5 = $z5;

                $r6 = min($value->penjualan_sedang, $value->stok_tinggi);
                $z6 = 
                    $value->stok_berkurang - min($value->penjualan_sedang, $value->stok_tinggi) * 
                    ($value->stok_bertambah - $value->stok_berkurang);

                $value->r6 = $r6;
                $value->z6 = $z6;

                $r7 = min($value->penjualan_rendah, $value->stok_rendah);
                $z7 = 
                    $value->stok_berkurang - min($value->penjualan_rendah, $value->stok_rendah) * 
                    ($value->stok_bertambah - $value->stok_berkurang);

                $value->r7 = $r7;
                $value->z7 = $z7;

                $r8 = min($value->penjualan_rendah, $value->stok_sedang);
                $z8 = 
                    $value->stok_berkurang - min($value->penjualan_rendah, $value->stok_sedang) * 
                    ($value->stok_bertambah - $value->stok_berkurang);

                $value->r8 = $r8;
                $value->z8 = $z8;

                $r9 = min($value->penjualan_rendah, $value->stok_tinggi);
                $z9 = 
                    $value->stok_berkurang - min($value->penjualan_rendah, $value->stok_tinggi) * 
                    ($value->stok_bertambah - $value->stok_berkurang);

                $value->r9 = $r9;
                $value->z9 = $z9;

                $value->atas = ($r1*$z1+$r2*$z2+$r3*$z3+$r4*$z4+$r5*$z5+$r6*$z6+$r7*$z7+$r8*$z8+$r9*$z9);

                $value->bawah = ($r1+$r2+$r3+$r4+$r5+$r6+$r7+$r8+$r9);

                if(! ($r1+$r2+$r3+$r4+$r5+$r6+$r7+$r8+$r9)) {
                    $value->estimasi = 'Tak Terhingga';
                    continue;
                }
                $value->estimasi = 
                    round(($r1*$z1+$r2*$z2+$r3*$z3+$r4*$z4+$r5*$z5+$r6*$z6+$r7*$z7+$r8*$z8+$r9*$z9) / 
                      ($r1+$r2+$r3+$r4+$r5+$r6+$r7+$r8+$r9));
            // dump($value);
        }

        // dump($barang);

        return view("sistem.est", ['barangs' => $barang]);
    }

    public function getEst()
    {
        // $getNowDate = new Carbon();
        // $getNowDate = Carbon::now()->format('d-m-Y');

        // $getLastMonthDate = new Carbon();
        // $getLastMonthDate = Carbon::now()->subMonth()->format('d-m-Y');

        // $getCurrMonth = new Carbon();
        // $getCurrMonth = Carbon::now()->format('Y-m');
        // $getLastMonth = new Carbon();
        // $getLastMonth = Carbon::now()->subMonth()->format('Y-m');

        $getCurrMonth = date('Y-m', strtotime(request('tanggal_bulan_sekarang')));
        $getLastMonth = date('Y-m', strtotime(request('tanggal_bulan_kemarin')));
        $bulan_ini = date('M (Y)', strtotime(request('tanggal_bulan_sekarang')));
        $bulan_lalu = date('M (Y)', strtotime(request('tanggal_bulan_kemarin')));


        $nowEst = Penjualan::select('*', DB::raw('SUM(jumlah_barang) AS total_sekarang'))
                            ->where('tanggal_pesan', 'LIKE', '%'.$getCurrMonth.'%')
                            ->groupBy('nama_barang')
                            ->orderBY('nama_barang', 'asc')
                            ->get();

        $lastEst = Penjualan::select('*', DB::raw('SUM(jumlah_barang) AS total_lalu'))
                            ->where('tanggal_pesan', 'LIKE', '%'.$getLastMonth.'%')
                            ->groupBy('nama_barang')
                            ->orderBY('nama_barang', 'asc')
                            ->get();

        $mainEst = Penjualan::select('*', DB::raw('SUM(jumlah_barang) AS total_sekarang'))
                            ->where('tanggal_pesan', 'LIKE', '%'.$getLastMonth.'%')
                            ->orWhere('tanggal_pesan', 'LIKE', '%'.$getCurrMonth.'%')
                            ->groupBy('nama_barang')
                            ->orderBY('nama_barang', 'asc')
                            // ->union($nowEst)
                            // ->union($lastEst)
                            ->get();

        // echo count($nowEst);

        // die();

        $retEstimasi = [];
        for($i=0;$i<count($nowEst);$i++) :

            $tmpEst = [];

            if ($nowEst[$i]->jumlah_barang > $lastEst[$i]->jumlah_barang) :
                $retEstimasi[$i] = $nowEst[$i]->jumlah_barang - $lastEst[$i]->jumlah_barang;
            elseif ($nowEst[$i]->jumlah_barang < $lastEst[$i]->jumlah_barang) :
                $retEstimasi[$i] = $lastEst[$i]->jumlah_barang - $nowEst[$i]->jumlah_barang;
            else :
                $retEstimasi[$i] = 0;
            endif;
        endfor;

        // $model = new Penjualan();

        // if (!empty(request('tanggal_bulan_kemarin'))) {
        //     $model = $model->where('tanggal_pesan', '>=', request('tanggal_bulan_kemarin'));
        // }

        // if (!empty(request('tanggal_bulan_sekarang'))) {
        //     $model = $model->where('tanggal_pesan', '<=', request('tanggal_bulan_sekarang'));
        // }

        // $penjualan = $model->get();

        // $bulan_ini = new Carbon();
        // $bulan_ini = Carbon::now()->format('F \\of Y');
        // $bulan_lalu = new Carbon();
        // $bulan_lalu = Carbon::now()->subMonth()->format('F \\of Y');

        // dd($nowEst);

        $data = [
            // 'penjualan' => $penjualan,
            'data' => $mainEst,
            'data_sekarang' => $nowEst,
            'data_lalu' => $lastEst,
            'estimasi' => $retEstimasi,
            'bulan_ini' => $bulan_ini,
            'bulan_lalu' => $bulan_lalu
        ];

        return view("sistem.est", $data);
    }

    public function laporanPenjualan()
    {
        if(!empty(request('tanggal1') && request('tanggal2'))) {
            $terjual = Penjualan::whereBetween('tanggal_pesan', [request('tanggal1'), request('tanggal2')])->get();

            $total_jual = 0;
            $total_harga = 0;
            $total = 0;

            foreach($terjual as $jual)
            {
                $total_jual = $total_jual + $jual->jumlah_barang;
                $total_harga = $total_harga + $jual->harga;
                $total = $total + $jual->total;
            }

            // dd($total_jual);

            return view('sistem.laporan_penjualan', ['data_jual' => $terjual, 'total_jual' => $total_jual, 'total_harga' => $total_harga, 'total' => $total]);
        }

        return view('sistem.laporan_penjualan');
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
            $terjual = Penjualan::whereBetween('tanggal_pesan', [request('tanggal1'), request('tanggal2')])->get();

            // dd($terjual);
            // die();

            $total_jual = 0;
            $total_harga = 0;
            $total = 0;

            foreach($terjual as $jual)
            {
                $total_jual = $total_jual + $jual->jumlah_barang;
                $total_harga = $total_harga + $jual->harga;
                $total = $total + $jual->total;
            }
            $data = [
                'data_jual' => $terjual, 
                'total_jual' => $total_jual, 
                'total_harga' => $total_harga, 
                'total' => $total
            ];

            // dd($data);
            // die();

            $dompdf = new Dompdf();
            // $dompdf->loadHtml($html);

            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'landscape');
            
            $pdf = PDF::loadView('sistem.laporan_penjualan_pdf', $data);
            return $pdf->stream('invoice.pdf');
        } else {
            return redirect()->back();
        }
    }
}
