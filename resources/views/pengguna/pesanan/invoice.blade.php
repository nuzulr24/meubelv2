
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice #INV1810281</title>
    @include('pengguna.elemen.static_css')
    <style type="text/css">
    .site-navbar .site-logo span{
        text-transform: uppercase;
        color: #25262a;
        letter-spacing: .2em;
        font-size: 20px;
        padding-left: 10px;
        padding-right: 10px;
        border: 2px solid #25262a;
    }
    </style>
</head>
<body onload="print()">
<header class="site-navbar mt-lg-5" role="banner">
    <div class="container">
        <div class="text-center">
            <div class="site-logo">
                <span>YoayoStore</span>
            </div>
        </div>
        <hr class="mb-0" style="background-color: #00000082;">
    </div>
</header>
<div class="site-section pt-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header text-black">Detail Informasi</div>
                            <div class="card-body row">
                                <div class="col-md-4">
                                    <b class="text-black">Informasi Pengirim</b><hr>
                                    <i>From,</i>
                                    <b>Yoayo</b>Store<br>
                                    Universitas BSI Gedung D2,<br>
                                    Margonda Depok, Indonesia<br>
                                    No. Telepon: (123) 45678910<br>
                                    Email: info@yoayostore.com
                                </div>
                                <div class="col-md-4">
                                    <b class="text-black">Informasi Penerima</b><hr>
                                    <i>To,</i>
                                    <b>{{ $data_invoice->nama_penerima }}</b><br>
                                    {{ explode('|', $data_invoice->alamat_tujuan)[0] }}<br>
                                    No. Telepon: {{ $data_invoice->no_telepon }}<br>
                                    Pengiriman : {{ explode('|', $data_invoice->alamat_tujuan)[1] }}
                                </div>
                                <div class="col-md-4">
                                    <b class="text-black">Informasi Pembayaran</b><hr>
                                    <b>ID Pesanan:</b><br>{{ $data_invoice->id_pesanan }}<br>
                                    <b>No. Rekening:</b><br> {{ $data_invoice->bank.' '.$data_invoice->no_rekening.' a/n '.$data_invoice->atas_nama }}<br>
                                    <b>Tanggal Upload:</b><br> {{ $data_invoice->tanggal_upload }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="site-blocks-table col-md-8 mt-5">
                <h4 class="text-black">Daftar Pesanan</h4>
                <hr>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="py-2 px-1">#No</th>
                            <th class="py-2 px-2">Nama Barang</th>
                            <th class="py-2">Harga</th>
                            <th class="py-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total_biaya = 0; $total_berat = 0; $counter = 1; ?>
                        @foreach ($detail_pesanan as $item)
                            <tr>
                                <td class="py-2 px-1">#{{ $counter }}</td>
                                <td class="py-2 px-2">{{ $item->nama_barang.' x '.$item->jumlah_beli}}<br>{{ 'Berat : '.$item->subtotal_berat.'gram'  }}</td>
                                <td class="py-2">{{ Rupiah::create($item->harga_satuan) }}</td>
                                <td class="py-2">{{ Rupiah::create($item->subtotal_biaya) }}</td>
                            </tr>
                        <?php $counter++; $total_berat += $item->subtotal_berat; $total_biaya += $item->subtotal_biaya; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-4 mt-5">
                <div class="card">
                    <div class="card-header text-black">
                        Subtotal Pesanan
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Layanan</td>
                                    <td>:</td>
                                    <td>JNE (YES)</td>
                                </tr>
                                <tr>
                                    <td>Total Berat</td>
                                    <td>:</td>
                                    <td>{{ $total_berat.'gram'}}</td>
                                </tr>
                                <tr>
                                    <td>Ongkir</td>
                                    <td>:</td>
                                    <td>{{ $data_invoice->ongkos_kirim }}</td>
                                </tr>
                                <tr>
                                    <td>Total Biaya</td>
                                    <td>:</td>
                                    <td>{{ Rupiah::create($total_biaya) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('pengguna.elemen.static_js')
</body>
</html>

{{-- @endsection --}}
