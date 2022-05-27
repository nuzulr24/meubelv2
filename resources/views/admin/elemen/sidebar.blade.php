<!-- Sidebar Menu -->
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">NAVIGASI UTAMA</li>
    <!-- Optionally, you can add icons to the links -->
    <li><a href="{{ route('beranda_admin') }}"><i class="fa fa-home"></i> <span>Beranda</span></a></li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-list-alt"></i>
            <span>Kelola Produk</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="{{ route('list_produk') }}"><i class="fa fa-circle-o"></i> Produk</a></li>
            <li><a href="{{ route('kategori_produk') }}"><i class="fa fa-circle-o"></i> Kategori</a></li>
            <li><a href="{{ route('merk_produk') }}"><i class="fa fa-circle-o"></i> Merk</a></li>
        </ul>
    </li>
    @if (session('superadmin') == true)
    <li class="treeview">
        <a href="#">
            <i class="fa fa-users"></i>
            <span>Kelola Pengguna</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="{{ route('superadmin_pengguna') }}"><i class="fa fa-circle-o"></i> Pengguna</a></li>
            <li><a href="{{ route('superadmin_admin') }}"><i class="fa fa-circle-o"></i> Admin</a></li>
        </ul>
    </li>
    @endif
    <li><a href="{{ route('pengaturan') }}"><i class="fa fa-gears"></i> <span>Pengaturan Website</span></a></li>
    <li class="header">TRANSAKSI</li>
    <li><a href="{{ route('pembayaran_admin') }}"><i class="fa fa-money"></i> <span>Pembayaran <span class="label bg-red pull-right" id="jml_pembayaran"></span></span></a></li>
    <li><a href="{{ route('pesanan_admin') }}"><i class="fa fa-shopping-cart"></i> <span>Pesanan <span class="label bg-red pull-right" id="jml_pesanan"></span></span></a></li>
    <li><a href="{{ route('pengiriman_admin') }}"><i class="fa fa-truck"></i> <span>Pengiriman <span class="label bg-red pull-right" id="jml_pengiriman"></span></span></a></li>
    <li class="header">LAPORAN</li>
    <li><a href="{{ route('laporan_transaksi') }}"><i class="fa fa-file-text-o"></i> <span>Transaksi</span></a></li>
</ul>
<!-- /.sidebar-menu -->
