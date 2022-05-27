@extends('pengguna.master')


@section('title', 'Keranjang')

@section('breadcrumb')
<div class="bg-light py-3" data-aos="fade-up" data-aos-delay="100">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0">
                <a href="{{ route('beranda') }}">Beranda</a>
                <span class="mx-2 mb-0">/</span>
                <strong class="text-black">Keranjang</strong>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')

@if(!empty($data_keranjang[0]))

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
                        <strong><i class="fa fa-ban fa-fw"></i> SUCCESS!!</strong> {{ session('success') }} <br>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                @endif

            </div>
            <div class="site-blocks-table col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="product-thumbnail py-2">Gambar</th>
                            <th class="product-name py-2">Nama Produk</th>
                            <th class="product-price py-2">Harga</th>
                            <th class="product-quantity py-2">Jumlah</th>
                            <th class="product-total py-2">Subtotal</th>
                            <th class="product-remove py-2">Hapus</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php $total = 0; $index = 1; $warning = false;?>
                        @foreach ($data_keranjang as $item)

                        @if($item->jumlah_beli > $item->stok_barang)
                        <tr>
                            <td colspan="6">
                                <span class="alert alert-danger">
                                    <b>Warning!</b> Stok <i>'{{ $item->nama_barang }}'</i> kurang dari jumlah yang ingin di beli. Silahkan check detail produk untuk melihat jumlah stok.
                                </span>
                            </td>
                        </tr>
                        <?php $warning = true; ?>
                        @endif

                        <tr>
                            <td class="product-thumbnail">
                                {{ Html::image(asset('storage/produk/'.$item->foto_barang), $item->nama_barang, ['class' => 'img-fluid px-0', 'width' => '100']) }}
                            </td>
                            <td class="product-name">
                                <a href="{{ route('detail_produk', ['id_barang' => $item->id_barang]) }}">
                                <h2 class="h5 text-black">{{ $item->nama_barang }}<br><small>Berat Satuan : <i>{{ $item->berat_barang.'gram' }}</i></small></h2>
                                </a>
                            </td>
                            <td>{{ Rupiah::create($item->harga_satuan) }}</td>
                            <td width="200">
                                {{ Form::open(['route' => ['update_keranjang', $item->id_barang], 'method' => 'PUT']) }}
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                                    </div>
                                    <input type="text" class="form-control text-center" name="jumlah_beli" value="{{ $item->jumlah_beli }}" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <button type="submit" name="simpan" value="true" class="btn btn-block btn-outline-success"> Update</button>
                                </div>
                                {{ Form::close() }}
                            </td>
                            <td>{{ Rupiah::create($item->subtotal_biaya) }}</td>
                            <td>
                                {{ Form::open(['route' => ['delete_keranjang', $item->id_barang], 'method' => 'DELETE']) }}
                                    <button type="submit" class="btn btn-primary btn-sm" name="simpan" value="true">
                                        <span class="icon-close"></span>
                                    </button>
                                {{ Form::close() }}
                            </td>
                        </tr>

                        <?php $total += $item->subtotal_biaya; $index++;?>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="row mb-5">
                    <div class="col-md-6">
                        <a href="{{ route('produk') }}" class="btn btn-outline-primary btn-sm btn-block">Lanjutkan Belanja</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pl-5">
                <div class="row justify-content-end">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-12 text-right border-bottom mb-5">
                                <h3 class="text-black h4 text-uppercase">Total Keranjang</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <span class="text-black h5">Total Biaya</span>
                            </div>
                            <div class="col-md-6 text-right">
                                <strong class="text-primary h5" data-total="{{ $total }}">{{ Rupiah::create($total) }}</strong>
                            </div>
                            <div class="col-md-12">
                                <small class="text-muted">Total biaya di atas belum termasuk ongkos kirim.</small>
                            </div>
                        </div>
                        <hr class="border">
                        @if($warning == true)
                            {{ Form::open() }}
                        @else
                            {{ Form::open(['route' => 'checkout_method']) }}
                        @endif
                        <div class="row mb-5">
                            <div class="col-md-12 form-group">
                                <label for="inp_alamat" class="text-black h5">Pilih Alamat</label>
                                <select id="inp_alamat" class="form-control" name="pilih_alamat">
                                    <option selected="selected" value>Pilih Alamat...</option>
                                    @if($alamat->first()->alamat_rumah != NULL)
                                    <option value="1">Kirim Ke Alamat Sendiri</option>
                                    @endif
                                    <option value="2">Kirim Ke Alamat Lain</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button @if($warning == true) type="button" @else type="submit" @endif name="simpan" value="true" class="btn btn-primary btn-lg py-3 btn-block">Proses Checkout</button>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@else

<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <span class="icon-shopping_cart display-3 text-success"></span>
                <h2 class="display-3 text-black">Keranjang Kosong!</h2>
                <p class="lead mb-5">Silahkan pilih produk favorit anda di katalog kami.</p>
                <p><a href="{{ route('produk') }}" class="btn btn-sm btn-primary">Lanjut Berbelanja</a></p>
            </div>
        </div>
    </div>
</div>

@endif

@endsection
