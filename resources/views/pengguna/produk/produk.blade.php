@extends('pengguna.master')

@section('title', 'Produk')

@section('custom_css')
<style>
img.product {
    width: 250px; /* You can set the dimensions to whatever you want */
    height: 250px;
    object-fit: cover;
}
</style>
@endsection

@section('content')
<div class="site-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12">
                @if ($errors->any())

                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="icon-ban"></i> ERROR!!</strong><br>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                @elseif(session()->has('success'))

                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><i class="icon-check"></i> SUCCESS!!</strong> {{ session('success') }} <br>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                @endif
            </div>
            <div class="col-md-9 order-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="float-md-left mb-4">
                            <h2 class="text-black h5">
                                @if(empty($_GET['search']))
                                    Katalog Produk {!! !empty($data_filter) ? ' "<span class="text-primary">'.$data_filter.'</span>"': false !!}
                                @else
                                    Hasil Pencarian Produk {!! !empty($_GET['search']) ? ' <span class="text-primary">"'.$_GET['search'].'"</span>': false !!}
                                @endif
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    @forelse ($produk as $item)
                        <?php $tersedia = true; ?>
                        <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
                            <div class="block-4 text-center border">
                                <figure class="block-4-image">
                                    <a href="{{ route('detail_produk', ['id_barang' => $item->id_barang]) }}">
                                        {{ Html::image(asset('storage/produk/'.$item->foto_barang), $item->nama_barang, ['class' => 'img-fluid product p-1']) }}
                                    </a>
                                </figure>
                                <div class="block-4-text p-4">
                                    <h3><a href="{{ route('detail_produk', ['id_barang' => $item->id_barang]) }}">{{ $item->nama_barang }}</a></h3>
                                    <p class="my-2">oleh {{ getContact()['title'] }}</p>
                                    <p class="text-primary font-weight-bold">{{ Rupiah::create($item->harga_satuan) }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <?php $tersedia = false; ?>
                        <div class="col-sm-12 col-lg-12 mb-4" data-aos="fade">
                            <div class="block-4 text-center border-0">
                                <div class="block-4-text p-4">
                                    <h3><span class="icon-shopping-bag display-3"></span> <span class="display-3">Tidak Ditemukan</span></h3>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="pagination">
                    <?php
                        echo $produk->links();
                    ?>
                </div>
            </div>

            <div class="col-md-3 order-1 mb-5 mb-md-0">
                <div class="border p-4 rounded mb-4">
                    <h3 class="mb-3 h6 text-uppercase text-black d-block">Kategori</h3>
                    <ul class="list-unstyled mb-0">
                        @foreach ($kategori as $item)
                            <li class="mb-1">
                                <a href="{{ route('produk') }}/?kategori={{ strtolower(str_replace(' ', '-', $item['nama_kategori'])) }}" class="d-flex">
                                    <span>{{ $item['nama_kategori'] }}</span>
                                    <span class="text-black ml-auto">
                                        ({{ $item['jumlah_barang'] }})
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
