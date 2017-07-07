<div class="col-md-12">
    <h2>JAYA MOTOR ABADI</h2>
    <h5>JL.Permata NO.24 Driyorejo</h5>      
</div>

<table class="table table-striped table-bordered" border="1">
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