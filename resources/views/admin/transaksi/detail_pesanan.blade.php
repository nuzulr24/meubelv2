@extends('admin.master')

@section('title', 'Detail Pesanan')

@section('extra_css')

    {{ Html::style('admin_assets/component/datatables.net-bs/css/dataTables.bootstrap.min.css') }}

@endsection

@section('content-header')
<h1>
    Detail Pesanan
    <small>Halaman detail pesanan</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('beranda_admin') }}"><i class="fa fa-home"></i> Beranda</a></li>
    <li><i class="fa fa-shopping-cart fa-fw"></i> pesanan</li>
    <li><i class="fa fa-list-ol fa-fw"></i> detail pesanan</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <h2 class="page-header">
            <i class="fa fa-shopping-cart fa-fw"></i> <b>Yoayo</b>Store.
            <small class="pull-right">Tanggal: {{ (new DateTime)->format('Y-m-d') }} </small>
        </h2>
    </div>
  <!-- /.col -->
</div>
<!-- info row -->
<div class="row invoice-info">
    <div class="col-sm-4 invoice-col">
        From
        <address>
            <strong>YoayoStore.</strong><br>
            Universitas BSI Gedung D2,<br>
            Margonda Depok, Indonesia<br>
            Phone: (123) 45678910<br>
            Email: info@yoayostore.com
        </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-4 invoice-col">
        To
        <address>
            <strong>{{ $data_pesanan->nama_penerima }}</strong><br>
            {{ explode('|', $data_pesanan->alamat_tujuan)[0] }}<br>
            No. Telepon : {{ $data_pesanan->no_telepon }}<br>
            Destinasi : <strong>{{ explode('|', $data_pesanan->alamat_tujuan)[1] }}</strong>
        </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-4 invoice-col">
        <b>ID Pesanan:</b> <i>{{ $data_pesanan->id_pesanan }}</i><br>
        <b>Status Pesanan:</b> <i>{{ $status[$data_pesanan->status_pesanan] }}</i><br>
        @if($data_pesanan->status_pesanan >= 3)
        <b>No. Resi:</b> <i>{{ $data_pesanan->no_resi }}</i><br>
        <b>Tanggal Dikirim:</b> <i>{{ $data_pesanan->tanggal_dikirim }}</i><br>
        @if($data_pesanan->status_pesanan > 4)
            <b>Tanggal DiTerima:</b> <i>{{ $data_pesanan->tanggal_diterima }}</i><br>
        @endif
        @endif
    </div>
  <!-- /.col -->
</div>
<!-- /.row -->

<!-- Table row -->
<div class="row">
    <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga Satuan</th>
                    <th>Berat Satuan</th>
                    <th>Jumlah Beli</th>
                    <th>Total Berat</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $subtotal = 0; ?>
                @foreach ($data_detail as $item)
                <tr>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ Rupiah::create($item->harga_satuan) }}</td>
                    <td>{{ $item->berat_barang }}gram</td>
                    <td>{{ $item->jumlah_beli }}</td>
                    <td>{{ $item->subtotal_berat }}gram</td>
                    <td>{{ Rupiah::create($item->subtotal_biaya) }}</td>
                </tr>
                <?php $subtotal += $item->subtotal_biaya ?>
                @endforeach
            </tbody>
        </table>
    </div>
  <!-- /.col -->
</div>
<!-- /.row -->

<div class="row">
  <!-- accepted payments column -->
  <div class="col-xs-6">
    <p class="lead">Metode Pembayaran:</p>
    <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
      Transfer Bank <br>
      No. Rekening : {{ $pembayaran->bank.' '.$pembayaran->no_rekening.' a/n '.$pembayaran->atas_nama }} <br>
    </p>
  </div>
  <!-- /.col -->
  <div class="col-xs-6">
    <p class="lead">Tanggal Pesanan: {{ $data_pesanan->tanggal_pesanan }}</p>

    <div class="table-responsive">
        <table class="table">
            <tr>
                <th style="width:50%">Subtotal:</th>
                <td>{{ Rupiah::create($subtotal) }}</td>
            </tr>
            <tr>
                <th>Shipping:</th>
                <td>{{ Rupiah::create($data_pesanan->ongkos_kirim) }}</td>
            </tr>
            <tr>
                <th>Total:</th>
                <?php $total = $subtotal + $data_pesanan->ongkos_kirim; ?>
                <td>{{ Rupiah::create($total) }}</td>
            </tr>
        </table>
    </div>
 </div>
  <!-- /.col -->
</div>
<!-- /.row -->

<!-- this row will not appear when printing -->
{{-- <div class="row no-print">
  <div class="col-xs-12">
    <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
    <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
    </button>
    <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
      <i class="fa fa-download"></i> Generate PDF
    </button>
  </div>
</div> --}}
@endsection

@section('extra_js')

    {{ Html::script('admin_assets/component/datatables.net/js/jquery.dataTables.min.js') }}
    {{ Html::script('admin_assets/component/datatables.net-bs/js/dataTables.bootstrap.min.js') }}

    <script>
        $(document).ready(function() {
            $('#table_pesanan_di_proses').DataTable({
                'lengthChange': false,
                'length': 10,
            })
        })
    </script>

@endsection
