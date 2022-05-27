@extends('pengguna.master')


@section('title', 'Pembayaran')

@section('breadcrumb')
<div class="bg-light py-3" data-aos="fade-up" data-aos-delay="100">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0">
                <a href="{{ route('beranda') }}">Beranda</a>
                <span class="mx-2 mb-0">/</span>
                <strong class="text-black">Pembayaran</strong>
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

                <h3 class="text-black">Daftar Pembayaran</h3>
                <hr>

            </div>
            <div class="site-blocks-table col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="py-2">No</th>
                            <th class="py-2">Kode Pesanan</th>
                            <th class="py-2">Bank</th>
                            <th class="py-2">Atas Nama</th>
                            <th class="py-2">No. Rekening</th>
                            <th class="py-2">Total Pembayaran</th>
                            <th class="py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $index = 1; ?>
                        @forelse ($data_pembayaran as $item)
                        <tr>
                            <td @if(empty($item->foto_bukti)) rowspan="2" @endif>#{{ $index }}</td>
                            <td>#{{ $item->id_pesanan }}</td>
                            <td>{{ $item->bank }}</td>
                            <td>{{ $item->atas_nama }}</td>
                            <td>{{ $item->no_rekening }}</td>
                            <td>{{ Rupiah::create($item->total_bayar) }}</td>
                            <td>
                                @if($item->status_pembayaran == 0)
                                <span class="badge badge-secondary">
                                    <i class="fa fa-close fa-fw"></i> Belum Di Veifikasi
                                </span>
                                @else
                                <span class="badge badge-success">
                                    <i class="fa fa-close fa-fw"></i> Telah Di Veifikasi
                                </span>
                                @endif
                            </td>
                        </tr>
                        @if(empty($item->foto_bukti))
                        <tr style="background-color: rgba(108, 117, 125, 0.16)!important;">
                            <td class="py-2 text-left" colspan="7">
                                <b>Batas Waktu Pembayaran : </b><code>{{ $item->batas_pembayaran }}</code>
                            </td>
                        </tr>
                        @endif
                        <?php $index++; ?>
                        @empty
                        <tr>
                            <td class="py-2 text-center" colspan="8">
                                Belum Ada Pembayaran Yang Masuk...
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
