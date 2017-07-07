@extends('sistem.index')

@section('content')
<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2>Pembelian</h2>
            </div>
        </div>

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
                                    <th>Tanggal Pesan</th>
                                    <th>Jumlah Barang</th>
                                    <th>Harga Pokok Beli</th>
                                    <th>Harga Pokok Jual</th>
                                    <th>Status</th>
                                    <th class="center">Total</th>
                                    <th>Tombol Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pembeliana as $pembelian)
                                <tr class="odd gradeX">
                                    <td>{{ $pembelian->kode_barang }}</td>
                                    <td>{{ $pembelian->nama_barang }}</td>
                                    <td>{{ $pembelian->tanggal_pesan }}</td>
                                    <td class="center">{{ $pembelian->jumlah_barang }}</td>
                                    <td class="center">Rp. {{ $pembelian->harga_pokok_beli }}</td>
                                    <td class="center">Rp. {{ $pembelian->harga_pokok_jual }}</td>
                                    <td class="center">{{ $pembelian->status }}</td>
                                    <td class="center" width="100">Rp. {{ $pembelian->total }}</td>
                                    <td class="center" width="130px">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEdit{{ $pembelian->id_pembelian }}">Edit</button>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalDelete{{ $pembelian->id_pembelian }}">Delete</button>
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
<!-- end of page-wrapper -->

<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="z-index: 1060;">
        <div class="modal-content">

            <form action="{{ route('pembelian.store') }}" method="POST" role="form">
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
                    <label for="jumlah">Jumlah Barang</label>
                    <input type="text" name="jumlah" id="jumlah" class="form-control" value="" placeholder="Jumlah barang" required="required" /><br/>
                    <label for="harga1">Harga Pokok Beli</label>
                    <input type="text" name="harga1" id="harga1" class="form-control" value="" placeholder="Harga Pokok Beli" required="required" /><br/>
                    <label for="harga2">Harga Pokok Jual</label>
                    <input type="text" name="harga2" id="harga2" class="form-control" value="" placeholder="Harga Pokok Beli" required="required" /><br/>
                    <label for="status">Status</label>
                    <!-- <input type="text" name="status" id="status" class="form-control" value="" placeholder="Status" required="required" /><br/> -->
                    <select name="status" id="status" class="form-control">
                        <option value="disetujui">disetujui</option>
                        <option value="tidak disetujui">tidak</option>
                    </select>
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

@foreach($pembeliana as $pembelian)
<div class="modal fade" id="modalEdit{{ $pembelian->id_pembelian }}" tabindex="-1" role="dialog" aria-labelledby="myModalEdit">
    <div class="modal-dialog" role="document" style="z-index: 1060;">
        <div class="modal-content">
        
            <form action="{{ route('pembelian.update', $pembelian->id_pembelian ) }}" method="POST">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                {{ method_field('PUT') }}

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body">
                    <label for="kode">Kode Barang</label>
                    <input type="text" name="kode" id="kode" class="form-control" value="{{ $pembelian->kode_barang }}" placeholder="Kode barang" required="required" /><br/>
                    <label for="nama">Nama Barang</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ $pembelian->nama_barang }}" placeholder="Nama barang" required="required" /><br/>
                    <label for="tanggal">Tanggal Pesan</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $pembelian->tanggal_pesan }}" placeholder="Tanggal Pesan" required="required" /><br/>
                    <label for="jumlah">Jumlah Barang</label>
                    <input type="text" name="jumlah" id="jumlah" class="form-control" value="{{ $pembelian->jumlah_barang }}" placeholder="Jumlah barang" required="required" /><br/>
                    <label for="harga1">Harga Pokok Beli</label>
                    <input type="text" name="harga1" id="harga1" class="form-control" value="{{ $pembelian->harga_pokok_beli }}" placeholder="Harga Pokok Beli" required="required" /><br/>
                    <label for="harga2">Harga Pokok Jual</label>
                    <input type="text" name="harga2" id="harga2" class="form-control" value="{{ $pembelian->harga_pokok_jual }}" placeholder="Harga Pokok Beli" required="required" /><br/>
                    <label for="status">Status</label>
                    <!-- <input type="text" name="status" id="status" class="form-control" value="" placeholder="Status" required="required" /><br/> -->
                    <select name="status" id="status" class="form-control">
                        <option value="disetujui">disetujui</option>
                        <option value="tidak disetujui">tidak</option>
                    </select>
                    <!-- <label for="total">Total</label>
                    <input type="text" name="total" id="total" class="form-control" value="{{ $pembelian->total }}" placeholder="Total" required="required" /><br/> -->
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

@foreach($pembeliana as $pembelian)
<div class="modal fade" id="modalDelete{{ $pembelian->id_pembelian}}" tabindex="-1" role="dialog" aria-labelledby="myModalDelete">
    <div class="modal-dialog" role="document" style="z-index: 1060;">
        <div class="modal-content">

            <form action="{{ route('pembelian.destroy', $pembelian->id_pembelian ) }}" method="post">
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
            "lengthMenu": [[4, 7, 10], [4, 7, 10]]
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
        $('#kode, #jumlah, #harga2').val('');

        if( event.which == 13){
            event.preventDefault();
        }

        var nama_barang = e.target.value;

        $.get('cek/suku_cadang/'+ nama_barang, function(data){
            console.log(data);
            $('#kode').val(data.kd_barang);
            $('#jumlah').val(data.jumlah);
            $('#harga2').val(data.harga_jual);
        });
    });

            function filterColumn ( i ) {
                $('#dataTables-example').DataTable().column( i ).search(
                    $('input.form-control.input-sm').val()
                ).draw();
            }

</script>
@endpush