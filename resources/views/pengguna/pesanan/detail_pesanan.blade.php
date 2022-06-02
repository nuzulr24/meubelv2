@extends('pengguna.master')


@section('title', 'Pesanan')

@section('breadcrumb')
<div class="bg-light py-3" data-aos="fade-up" data-aos-delay="100">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0">
                <a href="{{ route('beranda') }}">Beranda</a>
                <span class="mx-2 mb-0">/</span>
                <a href="{{ route('pesanan') }}">Pesanan</a>
                <span class="mx-2 mb-0">/</span>
                <strong class="text-black">Detail</strong>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
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
                                    <i>Dari,</i>
                                    <b>{{ getContact()['title'] }}</b><br>
                                    {{ getContact()['address'] }}<br>
                                    No. Telepon: {{ getContact()['phone'] }}<br>
                                    Email: {{ getContact()['email'] }}
                                </div>
                                <div class="col-md-4">
                                    <b class="text-black">Informasi Penerima</b><hr>
                                    <i>Ke,</i>
                                    <b>{{ $data_detail->nama_penerima }}</b><br>
                                    <b>{{ $data_detail->alamat_tujuan }}</b><br>
                                    <b>{{ formatHandphone($data_detail->no_telepon) }}</b><br>
                                </div>
                                <div class="col-md-4">
                                <b class="text-black">Informasi Pembayaran</b><hr>
                                    <?php 
                                        if($data_detail->id_methode == 1)
                                        {
                                            // dd($data_detail->id_bank_receiver);
                                            $get_name = DB::table('tbl_rekening')->where('id', $data_detail->id_bank_receiver)->first();
                                            $inform = [
                                                'nama_bank' => DB::table('tbl_rekeningbank')->where('id', $get_name->id_bank)->value('nama'),
                                                'atas_nama' => $get_name->atas_nama,
                                                'norek' => $get_name->nomer_rekening
                                            ];
                                    ?>
                                    <b>ID Pesanan:</b><br>{{ $data_detail->id_pesanan }}<br>
                                    <b>No. Rekening:</b><br> {{ $data_detail->bank.' '.$data_detail->no_rekening.' a/n '.$data_detail->atas_nama }}<br>
                                    <b>Tanggal Upload:</b><br> {{ $data_detail->tanggal_upload }}
                                    <?php } else { ?>

                                    <?php } ?>
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
                                    <td>{{ strtoupper($data_detail->kurir) }} {{ !is_null($data_detail->layanan) ? '('.$data_detail->layanan.')' : '' }}</td>
                                </tr>
                                <tr>
                                    <td>Total Berat</td>
                                    <td>:</td>
                                    <td>{{ $total_berat.'gram'}}</td>
                                </tr>
                                <tr>
                                    <td>Ongkir</td>
                                    <td>:</td>
                                    <td>{{ $data_detail->ongkos_kirim }}</td>
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
        <div class="row">
            <div class="col-md-12">
                <div class="card text-black">
                    <div class="card-body row">
                        <div class="col-md-12">
                            <?php $status = ['Belum Di Proses', 'Telah Di Verifikasi', 'Sedang Di Proses',
                                'Telah Di Kirim', 'Telah Di Terima', 'Selesai'] ?>
                            <table class="table">
                                <tr>
                                @if($data_detail->dibatalkan == 0)
                                        <th><b>Status Pesanan : </b></th>
                                        <td>{{ $status[$data_detail->status_pesanan] }}</td>
                                    @if($data_detail->status_pesanan >= 3)
                                        <th><b>Di Kirim Pada : </b></th>
                                        <td>{{ $data_detail->tanggal_dikirim }}</td>
                                    @endif
                                    </tr>
                                    @if($data_detail->status_pesanan >= 3)
                                    <tr>
                                        <th><b>Di Terima Pada : </b></th>
                                        <td>{{ !empty($data_detail->tanggal_diterima) ? $data_detail->tanggal_diterima  : '-' }}</td>
                                        <th><b>No. Resi Pengiriman :</b></th>
                                        <td><code>{{ $data_detail->no_resi }}</code></td>
                                    </tr>
                                    @endif
                                @else
                                    <th><b>Status Pesanan : </b></th>
                                    <td>Dibatalkan</td>
                                @endif
                            </table>
                        </div>
                        @if($data_detail->status_pesanan == 3)
                            <div class="col-md-12 text-center">
                                {{ Form::open(['route' => ['konfirmasi_pesanan', $item->id_pesanan], 'method' => 'PUT', 'class' => 'my-0']) }}
                                    <input type="submit" class="btn btn-warning btn-xs py-1" name="simpan" value="Konfirmasi Pesanan">
                                {{ Form::open() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
