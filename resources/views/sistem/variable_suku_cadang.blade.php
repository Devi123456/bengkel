@extends('sistem.index')

@section('content')
<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
              <h2>Variable Suku cadang</h2>
            </div>
        </div>

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span>&times;</span>
            </button>
            {{ session('error') }}
        </div>
        @endif

        <!-- /. ROW  -->
        <hr />
        <div class="row">
            <div class="col-md-12">
                <!-- Advanced Tables -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Stok Barang</th>
                                        <th>Penjualan Min.</th>
                                        <th>Penjualan Sedang</th>
                                        <th>Penjualan Max.</th>
                                        <th>Stok Min.</th>
                                        <th>Stok Sedang</th>
                                        <th>Stok Max.</th>                                        
                                        <th>Stok Berkurang</th>
                                        <th>Stok Bertambah</th>
                                        <th>Tombol Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($barangs as $barang)
                                    <tr class="odd gradeX">
                                        <td class="center">{{$barang->kd_barang}}</td>
                                        <td>{{$barang->nama_barang}}</td>
                                        <td>{{$barang->stok_barang}}</td>
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
                                        <td class="center">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEdit{{ $barang->kd_barang }}">Edit</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <!--End Advanced Tables -->
            </div>
        </div>
    <!-- /. ROW  -->

    </div>
<!-- /. PAGE INNER  -->
</div>

@foreach($barangs as $barang)
<div class="modal fade" id="modalEdit{{ $barang->kd_barang }}" tabindex="-1" role="dialog" aria-labelledby="myModalEdit">
    <div class="modal-dialog" role="document" style="z-index: 1060;">
        <div class="modal-content">
        
            <form action="{{ url('variable_suku_cadang/' . $barang->kd_barang) }}" method="POST">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    <label for="kode">Kode Barang</label>
                    <input type="text" name="Kode" id="Kode" class="form-control" value="{{ $barang->kd_barang }}" placeholder="Kode barang" required="required" readonly /><br/>
                    <label for="nama">Nama Barang</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ $barang->nama_barang }}" placeholder="Nama barang" required="required" readonly /><br/>
                    <label for="stok">Stok Barang</label>
                    <input type="text" name="Stok" id="Stok" class="form-control" value="{{ $barang->stok_barang }}" placeholder="Stok barang " required="required" readonly /><br/>
                    <label for="stok">Penjualan Min.</label>
                    <input type="text" name="penjualan_min" id="penjualan_min" class="form-control" value="{{ $barang->penjualan_min }}" placeholder="Penjualan Minimum" required="required" /><br/>
                    <!-- <label for="stok">Penjualan Sedang</label>
                    <input type="text" name="penjualan_sedang" id="penjualan_sedang" class="form-control" value="{{ round(($barang->penjualan_max - $barang->penjualan_min) / 2) }}" placeholder="Penjualan Sedang" required="required" readonly /><br/> -->
                    <label for="stok">Penjualan Max.</label>
                    <input type="text" name="penjualan_max" id="penjualan_max" class="form-control" value="{{ $barang->penjualan_max }}" placeholder="Penjualan Maximum" required="required" /><br/>
                    <label for="stok">Stok Min.</label>
                    <input type="text" name="stok_min" id="stok_min" class="form-control" value="{{ $barang->stok_min }}" placeholder="Stok Minimum" required="required" /><br/>
                    <!-- <label for="stok">Stok Sedang</label>
                    <input type="text" name="stok_sedang" id="stok_sedang" class="form-control" value="{{ round(($barang->stok_max - $barang->stok_min) / 2) }}" placeholder="Stok Sedang" required="required" readonly /><br/> -->
                    <label for="stok">Stok Max.</label>
                    <input type="text" name="stok_max" id="stok_max" class="form-control" value="{{ $barang->stok_max }}" placeholder="Stok Maximum" required="required" /><br/>
                    <label for="stok">Stok Berkurang</label>
                    <input type="text" name="stok_berkurang" class="form-control" value="{{ $barang->stok_berkurang }}" placeholder="Stok Berkurang" required="required"/><br/>
                    <label for="stok">Stok Bertambah</label>
                    <input type="text" name="stok_bertambah" class="form-control" value="{{ $barang->stok_bertambah }}" placeholder="Stok Bertambah" required="required" /><br/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endforeach
<!-- end of modal -->

@endsection

@push('script')
    <script>
        $(document).ready(function () {
            $('#dataTables-example').dataTable({
                "lengthMenu": [[5, 10, 15], [5,10, 15]]
                        // "paging": false,
            });
            
            // $('#penjualan_min, #penjualan_max').keyup(function(){
                
            //     penjualan_sedang = Math.round(($('#penjualan_max').val() - $('#penjualan_min').val()) / 2)

            //     console.log(penjualan_sedang);

            //     $('#penjualan_sedang').val(penjualan_sedang);
            // })

            // $('#stok_min, #stok_max').keyup(function(){
            //     stok_sedang = Math.round(($('#stok_max').val() - $('#stok_min').val()) / 2)

            //     $('#stok_sedang').val(stok_sedang);
            // })
        });
    </script>
@endpush