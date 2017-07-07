@extends('sistem.index')

@section('content')
    <div id="page-wrapper" >
        <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>Transaksi</h2>   
                    </div>
                </div>
                 <!-- /. ROW  -->
               
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Advanced Tables
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Tanggal</th>
                                            <th>Jumlah Barang</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="odd gradeX">
                                            <td>001</td>
                                            <td>Internet</td>
                                            <td>20 maret 2017</td>
                                            <td class="center">5</td>
                                            <td class="center">100000</td>
                                        </tr>
                                        
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
@endsection

@push('script')
    <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable({
                    "lengthMenu": [[5, 7, 15], [5, 7, 15]]
                    // "paging": false,
                });
            });
    </script>
@endpush