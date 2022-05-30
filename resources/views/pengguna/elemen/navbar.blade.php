<nav class="site-navigation text-right text-md-center" role="navigation">
    <div class="container">
        <ul class="site-menu js-clone-nav d-none d-md-block">
            <li><a href="{{ route('beranda') }}">Beranda</a></li>
            <li class="has-children">
                <a href="#">Kategori</a>
                <ul class="dropdown" id="kategori">
                </ul>
            </li>
            <li><a href="{{ route('produk') }}">Katalog</a></li>
            <li><a href="#kontak">Kontak Kami</a></li>
            @if(session()->has('email_pengguna'))
                <li><a href="{{ route('logout') }}">Keluar</a></li>
            @else
                <li><a href="{{ route('register') }}">Daftar</a> / <a href="{{ route('login') }}" class="btn btn-xs btn-outline-primary ml-2 py-1">Masuk</a></li>
            @endif
        </ul>
    </div>
</nav>
