@extends('pengguna.master')


@section('title', 'Riwayat Pesanan')

@section('breadcrumb')
<div class="bg-light py-3" data-aos="fade-up" data-aos-delay="100">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0">
                <a href="{{ route('beranda') }}">Beranda</a>
                <span class="mx-2 mb-0">/</span>
                <a href="{{ route('pesanan') }}">Pesanan</a>
                <span class="mx-2 mb-0">/</span>
                <strong class="text-black">Riwayat</strong>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="site-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="col-md-6"><h3 class="text-black">Riwayat Pesanan</h3></div>
                <hr>
            </div>
            <div class="site-blocks-table col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="py-2">No</th>
                            <th class="py-2">Kode Pesanan</th>
                            <th class="py-2">No. Invoice</th>
                            <th class="py-2">Total Pembayaran</th>
                            <th class="py-2">Tanggal Pesanan</th>
                            <th class="py-2">Tanggal Diterima</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1;?>
                        @forelse ($data_pesanan as $item)
                        <?php $inv = DB::table('tbl_invoice')->where('id_pesanan', $item->id_pesanan)->first(); ?>
                            <tr>
                                <td class="py-2">{{ '#'.$count }}</td>
                                <td class="py-2">
                                    {{ $item->id_pesanan }}<br>
                                    <a href="{{ route('detail_pesanan', ['id_pesanan' => $item->id_pesanan]) }}">
                                        <span class="badge badge-info">
                                            Lihat Detail Pesanan
                                        </span>
                                    </a>
                                </td>
                                <td class="py-2">
                                    <a href="{{ route('invoice', ['id_invoice' => $inv->id_invoice]) }}" target="_blank" class="btn btn-outline-info btn-xs py-1">
                                        <i class="fa fa-search fa-fw"></i> {{ $inv->id_invoice }}
                                    </a>
                                </td>
                                <td class="py-2">{{ Rupiah::create($item->total_bayar) }}</td>
                                <td class="py-2">{{ $item->tanggal_pesanan }}</td>
                                <td class="py-2">{{ $item->tanggal_diterima }}</td>
                            </tr>
                        <?php $count++; ?>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-2">Tidak Ada Data...</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection