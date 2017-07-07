@extends('sistem.index')

@section('content')
<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2>Servis </h2>
            </div>
        </div>

        <!-- /. ROW  -->
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
                                    <th>Jenis Kendaraan</th>
                                    <th>Mekanik</th>
                                    <th style="min-width: 80px;text-align: center;">Tanggal</th>
                                    <th>No.atrian</th>
                                    <th>Jam mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Jumlah Barang</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                    <th style="min-width: 140px;text-align: center;">Tombol Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($service as $servis)
                                <tr class="odd gradeX">
                                    <td>{{ $servis->kode_barang }}</td>
                                    <td>{{ $servis->nama_barang }}</td>
                                    <td>{{ $servis->jenis_kendaraan}}</td>
                                    <td>{{ $servis->mekanik }}</td>
                                    <td width="250px">{{ $servis->tanggal }}</td>
                                    <td>{{ $servis->no_antrian }}</td>
                                    <td>{{ $servis->jam_mulai }}</td>
                                    <td>{{ $servis->jam_selesai }}</td>
                                    <td class="center">{{ $servis->jumlah_barang }}</td>
                                    <td class="center">Rp. {{ $servis->harga }}</td>
                                    <td>Rp. {{ $servis->total }}</td>
                                    <td class="center">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEdit{{ $servis->id_servis }}">Edit</button>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDelete{{ $servis->id_servis }}">Delete</button>
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
    <!-- /.row -->
    </div>
    <!-- /. PAGE INNER  -->
</div><!-- end of page-wrapper -->

<!-- <div class="modal fade" id="modalRincian" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="z-index: 1060;">
        <div class="modal-content">
      
            <form action="{{ route('servis.store') }}" method="POST" role="form">
                {{ csrf_field() }}

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Rincian</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <label for="nama">Mekanik</label>
                        <input type="text" name="mekanik" id="mekanik" class="rincian-nama form-control" value="" placeholder="Mekanik" required="required" /><br/>
                    </div>      
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Rincian</button>
                </div>

            </form>
        </div>
    </div>
</div> -->
<!-- end of modal -->


<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="z-index: 1060;">
        <div class="modal-content">
      
            <form action="{{ route('servis.store') }}" method="POST" role="form">
                {{ csrf_field() }}

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Tambah</h4>
                </div>
                <div class="modal-body">
                    <label for="kode">Kode Barang</label>
                    <input type="text" name="kode" id="kode" class="form-control" value="" placeholder="Kode Barang" required="required" /><br/>
                    <label for="nama">Nama Barang</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="" placeholder="Nama Barang" required="required" /><br/>
                    <label for="kendaraan">Jenis Kendaraan</label>
                    <input type="text" name="kendaraan" id="kendaraan" class="form-control" value="" placeholder="Jenis Kendaraan" required="required" /><br/>
                    <label for="mekanik">Mekanik</label>
                    <input type="text" name="mekanik" id="mekanik" class="form-control" value="" placeholder="Mekanik" required="required" /><br/>
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="" placeholder="Tanggal Pesan" required="required" /><br/>
                    <label for="no_antrian">No.atrian</label>
                    <input type="text" name="no_antrian" id="no_antrian" class="form-control" value="" placeholder="Nomor antrian" required="required" /><br/>
                    <label for="mulai">Jam Mulai</label>
                    <input type="time" name="mulai" id="mulai" class="form-control" value="" placeholder="Jam Mulai" required="required" /><br/>
                    <label for="selesai">Jam Selesai</label>
                    <input type="time" name="selesai" id="selesai" class="form-control" value="" placeholder="Jumlah Selesai" required="required" /><br/>
                    <label for="jumlah">Jumlah Barang</label>
                    <input type="text" name="jumlah" id="jumlah" class="form-control" value="" placeholder="Jumlah Barang" required="required" /><br/>
                    <label for="harga">Harga</label>
                    <input type="text" name="harga" id="harga" class="form-control" value="" placeholder="Harga Barang" required="required" /><br/>
                    <!-- <label for="total">Total</label>
                    <input type="text" name="total" id="total" class="form-control" value="" placeholder="Total" required="required" /><br/> -->
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

@foreach($service as $servis)
<div class="modal fade" id="modalEdit{{ $servis->id_servis }}" tabindex="-1" role="dialog" aria-labelledby="myModalEdit">
    <div class="modal-dialog" role="document" style="z-index: 1060;">
        <div class="modal-content">
        
            <form action="{{ route('servis.update', $servis->id_servis ) }}" method="POST">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                {{ method_field('PUT') }}

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body">
                    <label for="kode">Kode Barang</label>
                    <input type="text" name="kode" id="kode" class="form-control" value="{{ $servis->kode_barang }}" placeholder="Kode Barang" required="required" /><br/>
                    <label for="nama">Nama Barang</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ $servis->nama_barang }}" placeholder="Nama Barang" required="required" /><br/>
                    <label for="nama">Jenis Kendaraan</label>
                    <input type="text" name="kendaraan" id="kendaraan" class="form-control" value="{{ $servis->jenis_kendaraan }}" placeholder="Jenis Kendaraan" required="required" /><br/>
                    <label for="mekanik">Mekanik</label>
                    <input type="text" name="mekanik" id="mekanik" class="form-control" value="{{ $servis->mekanik }}" placeholder="Mekanik" required="required" /><br/>
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $servis->tanggal }}" placeholder="Tanggal Pesan" required="required" /><br/>
                    <label for="no_antrian">No.atrian</label>
                    <input type="text" name="no_antrian" id="no_antrian" class="form-control" value="{{ $servis->no_antrian }}" placeholder="Nomor antrian" required="required" /><br/>
                    <label for="mulai">Jam Mulai</label>
                    <input type="time" name="mulai" id="mulai" class="form-control" value="{{ $servis->jam_mulai }}" placeholder="Jam Mulai" required="required" /><br/>
                    <label for="selesai">Jam Selesai</label>
                    <input type="time" name="selesai" id="selesai" class="form-control" value="{{ $servis->jam_selesai }}" placeholder="Jumlah Selesai" required="required" /><br/>
                    <label for="jumlah">Jumlah Barang</label>
                    <input type="text" name="jumlah" id="jumlah" class="form-control" value="{{ $servis->jumlah_barang }}" placeholder="Jumlah Barang" required="required" /><br/>
                    <label for="harga">Harga</label>
                    <input type="text" name="harga" id="harga" class="form-control" value="{{ $servis->harga }}" placeholder="Harga Barang" required="required" /><br/>
                    <label for="total">Total</label>
                    <input type="text" name="total" id="total" class="form-control" value="{{ $servis->total }}" placeholder="Total" required="required" /><br/>
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

@foreach($service as $servis)
<div class="modal fade" id="modalDelete{{ $servis->id_servis}}" tabindex="-1" role="dialog" aria-labelledby="myModalDelete">
    <div class="modal-dialog" role="document" style="z-index: 1060;">
        <div class="modal-content">

            <form action="{{ route('servis.destroy', $servis->id_servis ) }}" method="post">
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
            "lengthMenu": [[5, 10, 15], [5,10, 15]],
                    "searching": false
                    // "paging": false,
                });

         // tombol tambah
        $('#dataTables-example_wrapper .row:first-child div').removeClass().addClass('col-md-4');
        $('#dataTables-example_wrapper .row:first-child div.col-md-4').first().after('<div class="col-md-4"><button class="btn btn-default" type="button" data-toggle="modal" data-target="#modalTambah">Tambah</button></div>');
        $('#dataTables-example_wrapper .row:first-child div div').removeClass().addClass('col-md-12');
    });
</script>
@endpush