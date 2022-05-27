@extends('pengguna.master')

@section('title', 'Beranda')

@section('content')
<div class="site-blocks-cover" style="background-image: url({{ asset('user_assets/images/banner.jpg') }});" data-aos="fade">
    <div class="container">
        <div class="row align-items-start align-items-md-center justify-content-end">
            <div class="col-md-5 text-center text-md-left pt-5 pt-md-0">
                <h1 class="mb-2 text-white">Temukan Alat Olahraga Favoritmu.</h1>
                <div class="intro-text text-center text-md-left">
                    <p class="mb-4 text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at iaculis quam. Integer accumsan tincidunt fringilla. </p>
                    <p>
                        <a href="{{ route('produk') }}" class="btn btn-sm btn-primary">Belanja Sekarang</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="site-section site-section-sm site-blocks-1">
    <div class="container">
        <div class="row justify-content-center" data-aos="fade-up">
            <div class="col-md-12 site-section-heading text-center pt-4 pb-5">
                <h2>Kenapa Harus Di YoAyoStore?</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="">
                <div class="icon mr-4 align-self-start">
                    <span class="icon-truck"></span>
                </div>
                <div class="text">
                    <h2 class="text-uppercase">Pengiriman Cepat</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at iaculis quam. Integer accumsan tincidunt fringilla.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="100">
                <div class="icon mr-4 align-self-start">
                    <span class="icon-shield"></span>
                </div>
                <div class="text">
                    <h2 class="text-uppercase">Aman & Terpercaya</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at iaculis quam. Integer accumsan tincidunt fringilla.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="200">
                <div class="icon mr-4 align-self-start">
                    <span class="icon-help"></span>
                </div>
                <div class="text">
                    <h2 class="text-uppercase">Layanan Pelanggan</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at iaculis quam. Integer accumsan tincidunt fringilla.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="site-section site-blocks-2">
    <div class="container">
        <div class="row justify-content-center" data-aos="fade-up">
            <div class="col-md-12 site-section-heading text-center pt-4 pb-5">
                <h2>Lihat Koleksi Terbaru</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0" data-aos="fade" data-aos-delay="">
                <a class="block-2-item item1" href="{{ route('produk') }}?kategori=sepak-bola">
                    <figure class="image">
                        <img src="{{ asset('user_assets/images/soccer.jpg') }}" alt="" class="img-fluid">
                    </figure>
                    <div class="text">
                        <span class="text-uppercase">Lihat Koleksi</span>
                        <h3>Sepak Bola</h3>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="100">
                <a class="block-2-item item2" href="{{ route('produk') }}?kategori=basket">
                    <figure class="image">
                        <img src="{{ asset('user_assets/images/basketball.jpg') }}" alt="" class="img-fluid">
                    </figure>
                    <div class="text">
                        <span class="text-uppercase">Lihat Koleksi</span>
                        <h3>Basket</h3>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="200">
                <a class="block-2-item item3" href="{{ route('produk') }}?kategori=tennis">
                    <figure class="image">
                        <img src="{{ asset('user_assets/images/tennis.jpg') }}" alt="" class="img-fluid">
                    </figure>
                    <div class="text">
                        <span class="text-uppercase">Lihat Koleksi</span>
                        <h3>Tennis</h3>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
