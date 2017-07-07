@extends('sistem.index')

@section('content')
<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h3>Laporan Servis</h3>
                <h2>JAYA MOTOR ABADI</h2>
                <h5>JL.Permata NO.24 Driyorejo</h5>      
            </div>
        </div>
        <!-- /. ROW  -->
        <hr />

           <!--  <div class="table-responsive"> -->
                        <!-- table 1 -->
                        <form action="{{ route('servis.laporan') }}" method="get" class="pull-left">
                            <table>
                                <tr>
                                    <td width="100px;">Tanggal awal</td>
                                    <td width="30px;"><h4>:</h4></td>
                                    <td><input type="date" name="tanggal1" id="tanggal1" class="form-control" value="" placeholder="Tanggal Awal" required="required" /></td>
                                    <td>Tanggal akhir</td>
                                    <td width="30px;"><h4>:</h4></td>
                                    <td><input type="date" name="tanggal2" id="tanggal2" class="form-control" value="" placeholder="Tanggal Akhir" required="required" /></td>
                                    <td><button type="submit" class="btn btn-primary">Filter</button></td>                                   
                                </tr>                               
                            </table>
                        </form>
                        <div class="pull-right">
                            <button type="button" id="printpdf" class="btn btn-primary pull-right printpdf">Simpan Laporan</button>
                        </div>
                        <div class="clearfix"></div>
                        <hr style="height: 5px; background-color: black;">

                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Kendaraan</th>
                                    <th>Nama Barang</th>
                                    <th>Nama Mekanik</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @if(isset($data_servis))
                                    @foreach($data_servis as $laporan)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $laporan->tanggal }}</td>
                                        <td>{{ $laporan->jenis_kendaraan }}</td>
                                        <td>{{ $laporan->nama_barang }}</td>
                                        <td>{{ $laporan->mekanik }}</td>
                                        <td>Rp. {{ $laporan->total }}</td>
                                    </tr>
                                    <?php $no++; ?>
                                    @endforeach
                                    <tr>
                                        <td colspan="5">Jumlah</td>
                                        <td>Rp. {{ $total }}</td>
                                    </tr>
                                @else
                                <tr>
                                    <td colspan="6" style="text-align: center;">data kosong</td>
                                </tr>
                                <tr>
                                    <td colspan="5">Jumlah</td>
                                    <td>0</td>
                                </tr>
                                @endif                                
                            </tbody>
                        </table>
                        
                    <!-- </div> -->
                    <br>    
                </div>
            </div>
            <!--End Advanced Tables -->
        
    </div>
    <!-- /. PAGE INNER  -->
</div>
@endsection

@push('script')
    <script type="text/javascript">

        $('#printpdf').on('click', function(){
            var tgl_1 = $('#tanggal1').val();
            var tgl_2 = $('#tanggal2').val();

            if (tgl_1 == '' || tgl_2 == '') {
                alert('Masukkan tanggal awal dan tanggal akhir dengan benar !');
            } else {
                var url = "{{url('/print_pdf_servis?tanggal1=')}}"+tgl_1+'&tanggal2='+tgl_2;
                // window.location.href = ;
                // console.log(url)
                window.open(url, '_blank');

            }

            // console.log(tgl_1);
        });
        
        

    </script>
@endpush
