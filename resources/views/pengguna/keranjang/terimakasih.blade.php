@extends('pengguna.master')


@section('title', 'Terima Kasih')

@section('breadcrumb')
<div class="bg-light py-3" data-aos="fade-up" data-aos-delay="100">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0">
                <a href="{{ route('beranda') }}">Beranda</a>
                <span class="mx-2 mb-0">/</span>
                <strong class="text-black">Checkout</strong>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <span class="icon-check_circle display-3 text-success"></span>
                <h2 class="display-3 text-black">Terima Kasih</h2>
                <p class="lead mb-5">Pesanan anda telah sukses di proses.</p>
                <p><a href="{{ route('produk') }}" class="btn btn-sm btn-primary">Belanja Kembali</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
