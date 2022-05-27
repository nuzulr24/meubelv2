<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Laporan Transaksi</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
@include('admin.elemen.static_css')

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body>
<div class="wrapper">
<!-- Main content -->
<?php $carbon = new Carbon\Carbon(); ?>
<section class="invoice">
    <!-- title row -->
    <div class="row">
    <div class="col-xs-12">
        <h2 class="page-header">
        <i class="fa fa-shopping-cart"></i> <b>Yoayo</b>Store.
        <small class="pull-right">Tanggal Dicetak: {{ $carbon::parse($carbon::now())->toFormattedDateString() }}</small>
        </h2>
    </div>
    <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
    <div class="col-sm-12">
        <h2 class="text-center">Laporan Transaksi</h2>
        <hr>
    </div>
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
    <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>ID Pesanan</th>
                    <th>Layanan</th>
                    <th>Ongkos Kirim</th>
                    <th>Total Bayar</th>
                    <th>Tanggal Pesanan</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 1; $total_pendapatan = 0; $total_onkos = 0;?>
                @foreach ($data_laporan as $item)
                <tr>
                    <td>{{ $counter }}</td>
                    <td>{{ $item->id_pesanan }}</td>
                    <td>{{ 'JNE - '.$item->layanan }}</td>
                    <td>{{ Rupiah::create($item->ongkos_kirim) }}</td>
                    <td>{{ Rupiah::create($item->total_bayar) }}</td>
                    <td>{{ $item->tanggal_pesanan }}</td>
                </tr>
                <?php $counter++; $total_pendapatan += $item->total_bayar; $total_onkos += $item->ongkos_kirim; ?>
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
        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            <strong>YoayoStore.</strong><br>
            Universitas BSI Gedung D2,<br>
            Margonda Depok, Indonesia<br>
            Phone: (123) 45678910<br>
            Email: info@yoayostore.com
        </p>
    </div>
    <!-- /.col -->
    <div class="col-xs-6">
        <div class="table-responsive">
        <table class="table">
            <tr>
                <th>Biaya Pengiriman</th>
                <td>{{ Rupiah::create($total_onkos) }}</td>
            </tr>
            <tr>
                <th>Total Pendapatan</th>
                <td>{{ Rupiah::create($total_pendapatan) }}</td>
            </tr>
        </table>
        </div>
    </div>
    <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
</div>
<!-- ./wrapper -->
{{ Html::script('admin_assets/component/jquery/dist/jquery.min.js') }}
<script>
    $(document).ready(function(){
        window.print()
    })
</script>
</body>
</html>
