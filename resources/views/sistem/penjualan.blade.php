@extends('sistem.index')

@section('content')
<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
               <h2>Penjualan</h2>
           </div>
       </div>

       @if(session('fail'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span>&times;</span>
            </button>
            {{ session('fail') }}
        </div>
        @endif

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
                                <th>Tanggal Pesan</th>
                                <th>Tanggal Tersedia</th>
                                <th>Jumlah Barang</th>
                                <th>Harga</th>
                                <th>total</th>
                                <th>Tombol Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($penjualana as $penjualan)
                            <tr class="odd gradeX">
                                <td>{{ $penjualan->kode_barang }}</td>
                                <td>{{ $penjualan->nama_barang }}</td>
                                <td>{{ $penjualan->tanggal_pesan }}</td>
                                <td>{{ $penjualan->tanggal_tersedia }}</td>
                                <td class="center">{{ $penjualan->jumlah_barang }}</td>
                                <td class="center">Rp. {{ $penjualan->harga }}</td>
                                <td>Rp. {{ $penjualan->total }}</td>
                                <td class="center">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEdit{{ $penjualan->id_penjualan }}">Edit</button>
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDelete{{ $penjualan->id_penjualan }}">Delete</button>
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

</div>
<!-- /. PAGE INNER  -->
</div>
<!-- end of page-wrapper -->

<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="z-index: 1060;">
        <div class="modal-content">

            <form action="{{ route('penjualan.store') }}" method="POST" role="form">
                {{ csrf_field() }}

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Tambah</h4>
                </div>
                <div class="modal-body">
                    <label for="kode">Kode Barang</label>
                    <input type="text" name="kode" id="kode" class="form-control" value="" placeholder="Kode barang" required="required" /><br/>
                    <label for="nama">Nama Barang</label>
                    <input type="text" name="nama" id="nama" class="tambah-nama form-control" value="" placeholder="Nama barang" required="required" /><br/>
                    <label for="tanggal">Tanggal Pesan</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="" placeholder="Tanggal Pesan" required="required" /><br/>
                    <label for="tanggal">Tanggal Tersedia</label>
                    <input type="date" name="tanggal1" id="tanggal1" class="form-control" value="" placeholder="Tanggal Tersedia" required="required" /><br/>
                    <label for="jumlah">Jumlah Barang</label>
                    <input type="text" name="jumlah" id="jumlah" class="form-control" value="" placeholder="Jumlah barang" required="required" /><br/>
                    <label for="harga">Harga(Rp)</label>
                    <input type="text" name="harga" id="harga" class="form-control" value="" placeholder="Harga barang" required="required" /><br/>
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

@foreach($penjualana as $penjualan)
<div class="modal fade" id="modalEdit{{ $penjualan->id_penjualan }}" tabindex="-1" role="dialog" aria-labelledby="myModalEdit">
    <div class="modal-dialog" role="document" style="z-index: 1060;">
        <div class="modal-content">

            <form action="{{ route('penjualan.update', $penjualan->id_penjualan ) }}" method="POST">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                {{ method_field('PUT') }}

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalEdit"></h4>
                </div>
                <div class="modal-body">
                    <label for="kode">Kode Barang</label>
                    <input type="text" name="kode" id="kode" class="form-control" value="{{ $penjualan->kode_barang }}" placeholder="Kode barang" required="required" /><br/>
                    <label for="nama">Nama Barang</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ $penjualan->nama_barang }}" placeholder="Nama barang" required="required" /><br/>
                    <label for="tanggal">Tanggal Pesan</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $penjualan->tanggal_pesan }}" placeholder="Tanggal Pesan" required="required" /><br/>
                    <label for="tanggal">Tanggal Tersedia</label>
                    <input type="date" name="tanggal1" id="tanggal1" class="form-control" value="{{ $penjualan->tanggal_tersedia }}" placeholder="Tanggal Tersedia" required="required" /><br/>
                    <label for="jumlah">Jumlah Barang</label>
                    <input type="text" name="jumlah" id="jumlah" class="form-control" value="{{ $penjualan->jumlah_barang }}" placeholder="Jumlah barang" required="required" /><br/>
                    <label for="harga">Harga(Rp)</label>
                    <input type="text" name="harga" id="harga" class="form-control" value="{{ $penjualan->harga }}" placeholder="Harga barang" required="required" /><br/>
                    <!-- <label for="total">Total</label>
                    <input type="text" name="total" id="total" class="form-control" value="{{ $penjualan->total }}" placeholder="Total" required="required" /><br/> -->
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

@foreach($penjualana as $penjualan)
<div class="modal fade" id="modalDelete{{ $penjualan->id_penjualan }}" tabindex="-1" role="dialog" aria-labelledby="myModalDelete">
    <div class="modal-dialog" role="document" style="z-index: 1060;">
        <div class="modal-content">

            <form action="{{ route('penjualan.destroy', $penjualan->id_penjualan ) }}" method="post">
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

                $('input.form-control.input-sm').on( 'keyup keydown keypress', function () {
                    filterColumn( 1 );
                } );
            });

    $( ".tambah-nama" ).autocomplete({
      source: function(request, response){
        $.ajax({
            url: "{{ url('cek/daftar_barang') }}" + "/" + $('.tambah-nama').val() + "?nmbrng=" + request.nmbrng,
            dataType: "json",
            success: function(data){
                console.log(response(data));
                response(data);
            }
        });
      },
      minLength: 2
    });

    $('.tambah-nama').on('change', function(e){
        $('#kode, #jumlah, #harga').val('');

        if( event.which == 13){
            event.preventDefault();
        }

        var nama_barang = e.target.value;

        $.get('cek/suku_cadang/'+ nama_barang, function(data){
            console.log(data);
            $('#kode').val(data.kd_barang);
            $('#jumlah').val(data.jumlah);
            $('#harga').val(data.harga_jual);
        });
    });

            function filterColumn ( i ) {
                $('#dataTables-example').DataTable().column( i ).search(
                    $('input.form-control.input-sm').val()
                ).draw();
            }
    </script>
@endpush