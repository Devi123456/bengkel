@extends('sistem.index')

@section('content')

<div id="page-wrapper" >
    <div id="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <h2>Estimasi Penjualan</h2>
                </div>
            </div>

                <!-- /. ROW  -->
                <hr />
            <div class="row">
                <div class="col-md-12">
                        <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            ESTIMASI PENJUALAN
                        </div>
                    <div class="panel-body">
                        
                        <form class="form-horizontal" method="GET" action="{{ url('est') }}">

                            <div class="row">

                                <div class="from-group">
                                    <label for="tanggal" class="col-md-2 control-label">Dari</label>  
                                
                                    <div class="col-md-3">
                                    <input type="date" name="from" id="tanggal" class="form-control" value="{{ request('from') }}" required="required" />
                                    </div>
                                </div>

                                <div class="from-group">
                                    <label for="tanggal1" class="col-md-2 control-label">Sampai</label>
                                    <div class="col-md-3">
                                    <input type="date" name="to" id="tanggal1" class="form-control" value="{{ request('to') }}" required="required" />
                                    </div>
                                </div>

                                <div class="from-group col-md-2">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>
                        <br/>
                        
                        @if(count($barangs))
                        <!--  <div class="table-responsive"> -->
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah Penjualan</th>
                                    <th>Penjualan Min.</th>
                                    <th>Penjualan Sedang</th>
                                    <th>Penjualan Max.</th>
                                    <th>Stok Min.</th>
                                    <th>Stok Sedang</th>
                                    <th>Stok Max.</th>                                        
                                    <th>Stok Berkurang</th>
                                    <th>Stok Bertambah</th>
                                    <th>Estimasi</th>
                                <tr>
                            </thead>
                            <tbody>
                                @foreach($barangs as $barang)
                                <tr class="odd gradeX">
                                    <td class="center">{{$barang->kode_barang}}</td>
                                    <td>{{$barang->nama_barang}}</td>
                                    <td>{{$barang->jumlah_jual}}</td>
                                    <td>{{$barang->penjualan_min}}</td>
                                    <td>
                                        {{ round(($barang->penjualan_max - $barang->penjualan_min) / 2) }}
                                    </td>
                                    <td>{{$barang->penjualan_max}}</td>
                                    <td>{{$barang->stok_min}}</td>
                                    <td>
                                        {{ round(($barang->stok_max - $barang->stok_min) / 2) }}
                                    </td>
                                    <td>{{$barang->stok_max}}</td>
                                    <td>{{$barang->stok_berkurang}}</td>
                                    <td>{{$barang->stok_bertambah}}</td>
                                    <th>{{$barang->estimasi}}</th>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                        @endif
                        
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
            <!-- /. ROW  -->

    </div>
    <!-- /. PAGE INNER  -->
</div>
<!-- end of page-wrapper -->

@endsection