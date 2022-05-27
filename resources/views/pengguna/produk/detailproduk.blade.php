@extends('pengguna.master')

@section('title', $detail->nama_barang)

@section('breadcrumb')
<div class="bg-light py-3" data-aos="fade-up" data-aos-delay="100">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0">
                <a href="{{ route('beranda') }}">Beranda</a>
                <span class="mx-2 mb-0">/</span>
                <a href="{{ route('produk') }}">Produk</a>
                <span class="mx-2 mb-0">/</span>
                <strong class="text-black">Detail</strong>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="site-section">
    <div class="container">
        <div class="row">
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
            <div class="col-md-6">
                {{ Html::image(asset('storage/produk/'.$detail->foto_barang), $detail->nama_barang, ['class' => 'img-fluid']) }}
            </div>
            <div class="col-md-6">
                <h2 class="text-black my-3"> {{ $detail->nama_barang }}</h2>
                {!! $detail->deskripsi_barang !!}
                <table class="table mb-5">
                <tr>
                    <td>Berat</td>
                    <td>:</td>
                    <td>{{ $detail->berat_barang }}gram</td>
                </tr>
                <tr>
                    <td>Stok</td>
                    <td>:</td>
                    <td><b>{{ $detail->stok_barang }}pcs</b></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>:</td>
                    <td>
                        @if($detail->stok_barang != 0)
                            <span class="badge badge-primary"><span class="icon-check"></span> Tersedia</span>
                        @else
                            <span class="badge badge-danger"><span class="icon-close"></span> Kosong</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Harga</td>
                    <td>:</td>
                    <td>
                        <strong class="text-primary"> {{ Rupiah::create($detail->harga_satuan) }} </strong>
                    </td>
                </tr>
            </table>
            {{ Form::open(['route' => ['tambah_keranjang', $detail->id_barang]]) }}
            <div class="mb-5">
                <div class="input-group mb-3" style="max-width: 120px;">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                    </div>
                    <input type="text" name="jumlah_beli" class="form-control text-center" value="1" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                    </div>
                </div>
            </div>
            <p>
            @if($detail->stok_barang != 0)
                <button type="submit" class="buy-now btn btn-sm btn-primary" name="simpan" value="true">
                    Tambah Ke Keranjang
                </button>
            @else
                <button type="button" class="buy-now btn btn-sm btn-primary" disabled>
                    Stok Kosong
                </button>
            @endif
            </p>
            {{ Form::close() }}
      </div>
    </div>
  </div>
</div>
@endsection
