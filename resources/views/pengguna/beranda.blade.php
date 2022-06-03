@extends('pengguna.master')

@section('title', 'Beranda')

@section('content')
<div class="site-blocks-cover" style="background-image: url('<?= Storage::url('images/'. getContact()['background']) ?>')" data-aos="fade">
    <div class="container">
        <div class="row align-items-start align-items-md-center justify-content-end">
            <div class="col-md-5 text-center text-md-left pt-5 pt-md-0">
                <h1 class="mb-2">Temukan Furnitur Terbaik kamu</h1>
                <div class="intro-text text-center text-md-left">
                    <p class="mb-4">Dapatkan furnitur terbaik dengan harga yang variatif serta kualitas yang terjamin</p>
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
                <h2>Kenapa Harus Di {{ DB::table('tbl_website')->where('id', 1)->value('value') }}?</h2>
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
            <?php foreach(DB::table('tbl_kategori')->take(3)->get() as $cat) { ?>
                <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0" data-aos="fade" data-aos-delay="">
                    <a class="block-2-item item1" href="{{ route('produk') }}?kategori=<?= str_slug($cat->nama_kategori) ?>">
                        <figure class="image">
                            <img src="<?= Storage::url('kategori/'. $cat->foto) ?>" alt="" class="img-fluid">
                        </figure>
                        <div class="text">
                            <span class="text-uppercase">Lihat Koleksi</span>
                            <h3><?= $cat->nama_kategori ?></h3>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
@endsection
