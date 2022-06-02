@extends('pengguna.master')


@section('title', 'Pesanan')

@section('breadcrumb')
<div class="bg-light py-3" data-aos="fade-up" data-aos-delay="100">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0">
                <a href="{{ route('beranda') }}">Beranda</a>
                <span class="mx-2 mb-0">/</span>
                <strong class="text-black">Pesanan</strong>
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
                <div class="row">
                    <div class="col-md-6"><h3 class="text-black">Daftar Pesanan</h3></div>
                    <div class="col-md-6">
                        <a href="{{ route('riwayat_pesanan') }}" class="btn btn-warning btn-xs py-2 float-right">Riwayat Pesanan</a>
                    </div>
                </div>
                <hr>

            </div>
            <div class="site-blocks-table col-md-12">
                <div class="alert alert-info">
                    <h5>INFO PEMBAYARAN!</h5>
                    <div class="py-2">
                        <p class="mb-0 text-black">
                            Silahkan Transfer Ke Rekening Di Bawah :<hr>
                            <?php
                                $data_bank = DB::table('tbl_rekening')->where('is_active', 1)->get();
                                foreach($data_bank as $items) {
                                    $nama_bank = DB::table('tbl_rekeningbank')->where('id', $items->id)->first();
                            ?>
                                <b>Nomer Rekening:&nbsp; {{ $items->nomer_rekening }}</b><br>
                                <b>Atas Nama:&nbsp; {{ $items->atas_nama }}</b><br>
                                <b>Nama Bank:&nbsp; {{ $nama_bank->nama }} (Kode Bank: {{ $nama_bank->kodebank }})</b>
                            <?php } ?>
                            <br>
                            Untuk saat ini kami hanya menggunakan rekening yang tertera di atas, <br>
                            jika anda transfer pembayaran selain rekening di atas kami tidak bertanggung jawab.
                            <hr>
                            <strong>Note : Setelah transfer pembayaran pada rekening di atas di harapkan untuk segera mengupload bukti pembayaran.</strong>
                        </p>
                    </div>
                </div>
            </div>
            <div class="site-blocks-table col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="py-2">No</th>
                            <th class="py-2">Kode Pesanan</th>
                            <th class="py-2">No. Invoice</th>
                            <th class="py-2">Total Pembayaran</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Batalkan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1;?>
                        <?php $status = ['Belum Di Proses', 'Telah Di Verifikasi', 'Sedang Di Proses',
                                         'Telah Di Kirim', 'Telah Di Terima', 'Selesai'] ?>
                        @forelse ($data_pesanan as $item)
                            <tr>
                                <td class="py-2" rowspan="2">{{ '#'.$count }}</td>
                                <td class="py-2">
                                    {{ '#'.$item->id_pesanan }}<br>
                                    <a href="{{ route('detail_pesanan', ['id_pesanan' => $item->id_pesanan]) }}">
                                        <span class="badge badge-info">
                                            Lihat Detail Pesanan
                                        </span>
                                    </a>
                                </td>
                                <?php $carbon = new Carbon\Carbon(); ?>
                                @if($carbon::parse(explode(' ', $carbon::now())[0])->lessThanOrEqualTo($carbon::parse($item->batas_pembayaran)) || !is_null($item->foto_bukti))
                                <td class="py-2">
                                    <?php $inv = DB::table('tbl_invoice')->where('id_pesanan', $item->id_pesanan)->first(); ?>
                                    @if($item->dibatalkan == 1)
                                        <span class="badge badge-danger">
                                            <i class="fa fa-close fa-fw"></i> Dibatalkan
                                        </span>
                                    @elseif($item->foto_bukti == NULL)
                                        <a href="{{ route('upload_bukti', ['id_pesanan' => $item->id_pesanan]) }}" class="btn btn-outline-warning btn-xs py-1">
                                            <i class="fa fa-upload fa-fw"></i> Upload Bukti
                                        </a><br>
                                        <small class="help-block">Upload bukti pembayaran.</small>
                                    @elseif($item->foto_bukti != NULL && $item->status_pembayaran == 0)
                                        <span class="badge badge-secondary">
                                            <i class="fa fa-close fa-fw"></i> Menunggu Verifikasi
                                        </span>
                                    @else
                                        <a href="{{ route('invoice', ['id_invoice' => $inv->id_invoice]) }}" target="_blank" class="btn btn-outline-info btn-xs py-1">
                                            <i class="fa fa-search fa-fw"></i> {{ $inv->id_invoice }}
                                        </a>
                                    @endif
                                </td>
                                <td class="py-2">{{ Rupiah::create($item->total_bayar) }}</td>
                                <td class="py-2">
                                    <b>@if($item->dibatalkan == 0)<?=$status[$item->status_pesanan]?>@else Dibatalkan @endif</b>
                                </td>
                                <td class="py-2">
                                    @if($item->status_pesanan >= 3)
                                        <span class="badge badge-danger">
                                            <i class="fa fa-close fa-fw"></i> Tidak Dapat Dibatalkan
                                        </span>
                                    @elseif($item->dibatalkan == 1)
                                        <span class="badge badge-danger">
                                            <i class="fa fa-close fa-fw"></i> Dibatalkan
                                        </span>
                                    @else
                                        {{ Form::open(['route' => ['pesanan_dibatalkan', $item->id_pesanan], 'method' => 'PUT']) }}
                                        <input type="submit" class="btn btn-danger btn-xs py-1" name="simpan" value="Batalkan">
                                        {{ Form::open() }}
                                    @endif
                                </td>
                                @else
                                <td class="py-2 text-center" colspan="6">
                                    <code>TELAH MELAMPAUI BATAS PEMBAYARAN</code>
                                </td>
                                @endif
                            </tr>
                            @if($item->dibatalkan == 1)
                            <tr style="background-color: rgba(108, 117, 125, 0.16)!important;">
                                <td class="py-2 text-left" colspan="6">
                                   <code>Pesanan Telah Di Batalkan</code>
                                </td>
                            </tr>
                            @else
                                @if($item->status_pesanan >= 3 && $item->status_pesanan < 5 && $item->dibatalkan == 0)
                                <tr style="background-color: rgba(108, 117, 125, 0.16)!important;">
                                    <td class="py-2 text-left" colspan="6">
                                        <b>Resi Pengiriman : </b> <code>{{ $item->no_resi }}</code> | Dikirim Pada : {{ $item->tanggal_dikirim }} |
                                        Layanan Pengiriman : {{ strtoupper($item->kurir) }} {{ !is_null($item->layanan) ? ' - (' . $item->layanan . ')' : '' }}
                                        @if($item->status_pesanan == 4)
                                        | Diterima Pada : {{ $item->tanggal_diterima }}
                                        @else
                                        <br> <i><small>Jika Barang telah di terima harap konfirmasi pnerimaan pesanan</small></i>
                                        <span class="badge badge-warning"><a href="{{ route('detail_pesanan', ['id_pesanan' => $item->id_pesanan]) }}" class="text-black">Konfirmasi Pesanan</a></span>
                                        <i><small> | Track Pesanan :  </small></i><span class="badge badge-warning"><a data-kurir="{{ $item->kurir }}" data-resi="{{ $item->no_resi }}" class="text-black cari">Tracking Pesanan</a></span>
                                        <br><code>NOTE:</code>Jika kedapatan masalah saat pengiriman atau ingin mengajukan pembatalan pesanan silahkan hubungi kami pada kontak di bawah.</a>
                                        @endif
                                    </td>
                                </tr>
                                @elseif(empty($item->foto_bukti) && $item->dibatalkan == 0)
                                <tr style="background-color: rgba(108, 117, 125, 0.16)!important;">
                                    <td class="py-2 text-left" colspan="6">
                                        Batas Waktu Pembayaran : <code>{{ $item->batas_pembayaran }}</code>
                                    </td>
                                </tr>
                                @else
                                <tr style="background-color: rgba(108, 117, 125, 0.16)!important;">
                                    <td class="py-2 text-left" colspan="6">
                                        <code>PERHATIAN!! Pembatalan Pesanan Dapat Di Lakukan Sebelum Pesanan Di Kirim.
                                    </td>
                                </tr>
                                @endif
                            @endif

                                {{-- @if($item->status_pesanan <= 2 && $item->status_pesanan > 0 && $item->dibatalkan == 0)
                                <tr style="background-color: rgba(108, 117, 125, 0.16)!important;">
                                    <td class="py-2 text-left" colspan="6">
                                        <code>PERHATIAN!! Pembatalan Pesanan Dapat Di Lakukan Sebelum Pesanan Di Kirim. <br> Silahkan Hubungi Kontak Di Bawah Sebelum Melakukan Pembatalan.
                                    </td>
                                </tr>
                                @endif --}}

                            <?php $count++; ?>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-2">Tidak Ada Data...</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
                <div class="text-black">
                    <b>NOTE:</b> Jika ingin mencabut status pembatalan silahkan hubungi kontak di bawah.
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('modal')
<div class="modal fade" id="cariResi">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="judulResi"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body tracking">

      </div>
    </div>
  </div>
</div>
@endsection

@section('custom_js')

<script>
    $(document).ready(function () {
        $('.cari').click(function() {
            $('#cariResi').modal('show')
            $.ajax({
                url: "track/" + $(this).data('resi'),
                method: "GET",
                success: function (response) {
                    $('.tracking').html(response)
                    $('#judulResi').html('Lacak Pengiriman')
                },
            });
        })
    })

</script>

@endsection