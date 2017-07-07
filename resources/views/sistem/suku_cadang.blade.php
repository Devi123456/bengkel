@extends('sistem.index')

@section('content')
<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
              <h2>Suku cadang</h2>
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
                                        <th>Harga</th>
                                        <th>Tombol Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($barangs as $barang)
                                    <tr class="odd gradeX">
                                        <td class="center">{{$barang->kd_barang}}</td>
                                        <td>{{$barang->nama_barang}}</td>
                                        <td class="center">{{$barang->stok_barang}}</td>
                                        <td class="center">Rp. {{$barang->harga}}</td>
                                        <td class="center">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEdit{{ $barang->id_barang }}">Edit</button>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDelete{{ $barang->id_barang }}">Delete</button>
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

<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="z-index: 1060;">
        <div class="modal-content">
        
            <form action="{{ route('suku_cadang.store') }}" method="POST" role="form">
                {{ csrf_field() }}

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body">
                    <label for="kode">Kode Barang</label>
                    <input type="text" name="Kode" id="Kode" class="form-control" value="" placeholder="Kode barang" required="required" /><br/>
                    <label for="nama">Nama Barang</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="" placeholder="Nama barang" required="required" /><br/>
                    <label for="stok">Stok Barang</label>
                    <input type="text" name="Stok" id="Stok" class="form-control" value="" placeholder="Stok barang " required="required" /><br/>
                    <label for="harga">Harga(Rp)</label>
                    <input type="text" name="harga" id="harga" class="form-control" value="" placeholder="Harga barang " required="required" /><br/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- end of modal -->

@foreach($barangs as $barang)
<div class="modal fade" id="modalEdit{{ $barang->id_barang }}" tabindex="-1" role="dialog" aria-labelledby="myModalEdit">
    <div class="modal-dialog" role="document" style="z-index: 1060;">
        <div class="modal-content">
        
            <form action="{{ route('suku_cadang.update', $barang->id_barang ) }}" method="POST">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                {{ method_field('PUT') }}

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    <label for="kode">Kode Barang</label>
                    <input type="text" name="Kode" id="Kode" class="form-control" value="{{ $barang->kd_barang }}" placeholder="Kode barang" required="required" /><br/>
                    <label for="nama">Nama Barang</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ $barang->nama_barang }}" placeholder="Nama barang" required="required" /><br/>
                    <label for="stok">Stok Barang</label>
                    <input type="text" name="Stok" id="Stok" class="form-control" value="{{ $barang->stok_barang }}" placeholder="Stok barang " required="required" /><br/>
                    <label for="harga">Harga(Rp)</label>
                    <input type="text" name="harga" id="harga" class="form-control" value="{{ $barang->harga }}" placeholder="Harga barang " required="required" /><br/>
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

@foreach($barangs as $barang)
<div class="modal fade" id="modalDelete{{ $barang->id_barang}}" tabindex="-1" role="dialog" aria-labelledby="myModalDelete">
    <div class="modal-dialog" role="document" style="z-index: 1060;">
        <div class="modal-content">

            <form action="{{ route('suku_cadang.destroy', $barang->id_barang ) }}" method="post">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                {{ method_field('DELETE') }}

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalDelete">Hapus Data?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
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

            // tombol tambah
            $('#dataTables-example_wrapper .row:first-child div').removeClass().addClass('col-md-4');
            $('#dataTables-example_wrapper .row:first-child div.col-md-4').first().after('<div class="col-md-4"><button class="btn btn-default" type="button" data-toggle="modal" data-target="#modalTambah">Tambah</button></div>');
            $('#dataTables-example_wrapper .row:first-child div div').removeClass().addClass('col-md-12');
        });
    </script>
@endpush