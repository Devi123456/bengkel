<div class="col-md-12">
    <h2>JAYA MOTOR ABADI</h2>
    <h5>JL.Permata NO.24 Driyorejo</h5>      
</div>

<table class="table table-striped table-bordered" border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Barang</th>
            <th>Beli</th>
            <th>Harga</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        @if(isset($data_beli))
            @foreach($data_beli as $laporan)
            <tr>
                <td>{{ $no }}</td>
                <td>{{ $laporan->tanggal_pesan }}</td>
                <td>{{ $laporan->nama_barang }}</td>
                <td>{{ $laporan->jumlah_barang }}</td>
                <td>{{ $laporan->harga_pokok_beli }}</td>
                <td>{{ $laporan->total }}</td>
            </tr>
            <?php $no++; ?>
            @endforeach
            <tr>
                <td colspan="3">Jumlah</td>
                <td>{{ $total_beli }}</td>
                <td></td>
                <td>{{ $total }}</td>
            </tr>
        @else
        <tr>
            <td colspan="6" style="text-align: center;">data kosong</td>
        </tr>
        <tr >
            <td colspan="3">Jumlah</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        @endif                                
    </tbody>
</table>