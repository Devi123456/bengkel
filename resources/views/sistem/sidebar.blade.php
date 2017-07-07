@if(Auth::check())
    @if(Auth::user()->tipe == 'kasir')
    <li class="text-center">
        <img src="{{ asset('img/user.png') }}" class="user-image img-responsive"/>
    </li>

    <li>
        <a href="{{ url('suku_cadang') }}"><i class="glyphicon glyphicon-folder-open fa-3x"></i> Suku Cadang</a>
    </li>

    <li>
        <a href="{{ url('variable_suku_cadang') }}"><i class="glyphicon glyphicon-cog fa-3x"></i> Variable Suku Cadang</a>
    </li>

    <li>
        <a href="{{ url('pembelian') }}"><i class="fa fa-desktop fa-3x"></i> Pembelian</a>
    </li>
    <li>
        <a href="{{ url('penjualan') }}"><i class="fa fa-money fa-3x"></i> Penjualan</a>
    </li>
    <li>
        <a href="{{ url('servis') }}"><i class="fa fa-wrench fa-3x"></i> Servis </a>
    </li>
    <li>
        <a href="{{ url('est') }}"><i class="fa fa-calendar fa-3x"></i> Estimasi Jual</a>
    </li>
    {{-- <li>
        <a href="{{ url('est_pembelian') }}"><i class="fa fa-calendar fa-3x"></i> Estimasi Beli</a>
    </li> --}}
    <!-- <li>
        <a href="{{ url('transaksi') }}"><i class="fa fa-table fa-3x"></i> Transaksi</a>
    </li> -->
    @elseif(Auth::user()->tipe == 'pimpinan')
    <li>
        <a href="#">
            <i class="fa fa-sitemap fa-3x"></i> Laporan<span class="fa arrow"></span>
        </a>
        <ul class="nav nav-second-level">
            <li>
                <a href="{{ url('laporan_pembelian') }}">Laporan Pembelian</a>
            </li>
            <li>
                <a href="{{ url('laporan_penjualan') }}">Laporan Penjualan</a>
            </li>
            <li>
                <a href="{{ url('laporan_servis') }}">Laporan Servis</a>
            </li>
        </ul>
    </li>
    @endif
@endif