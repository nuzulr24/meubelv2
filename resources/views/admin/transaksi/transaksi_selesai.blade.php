@extends('admin.master')

@section('title', 'Manajemen Pesanan')

@section('extra_css')

    {{ Html::style('admin_assets/component/datatables.net-bs/css/dataTables.bootstrap.min.css') }}

@endsection

@section('content-header')
<h1>
    Pesanan Selesai
    <small>List pesanan selesai</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('beranda_admin') }}"><i class="fa fa-home"></i> Beranda</a></li>
    <li><i class="fa fa-shopping-cart fa-fw"></i> pesanan</li>
    <li><i class="fa fa-clipboard fa-fw"></i> pesanan selesai</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> ERROR!</h4>
                @foreach ($errors->all() as $error)
                    <li> {{ $error }} </li>
                @endforeach
            </div>
        @elseif (session()->has('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                {{ session('success') }}
            </div>
        @endif
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">
                    Pesanan Selesai
                </h3>
            </div>
            <div class="box-body">
                {{ Form::open(['method' => 'GET' ]) }}
                <div class="row">
                    <div class="col-md-12 col-md-offset-2">
                        <div class="col-md-12">
                            <label>Masukan Periode</label>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="awal" id="datepicker1" placeholder="Tanggal Awal">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control" name="akhir" id="datepicker2" placeholder="Tanggal Akhir">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane fa-fw"></i> Process</button>
                                <a href="{{ route('pesanan_selesai') }}" class="btn btn-warning"><i class="fa fa-refresh fa-fw"></i> Reset</a>
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
                @if(!empty($data_pesanan))
                <div class="table-responsive">
                    <table class="table table-striped" id="pesanan_selesai">
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
                            @foreach ($data_pesanan as $item)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td>
                                    <a href="{{ route('detail_pesanan_admin', ['id_pesanan' => $item->id_pesanan]) }}">
                                        {{ $item->id_pesanan }}
                                    </a>
                                </td>
                                <td>{{ 'JNE - '.$item->layanan }}</td>
                                <td>{{ Rupiah::create($item->ongkos_kirim) }}</td>
                                <td>{{ Rupiah::create($item->total_bayar) }}</td>
                                <td>{{ $item->tanggal_pesanan }}</td>
                            </tr>
                            <?php $total_pendapatan += $item->total_bayar; $total_onkos += $item->ongkos_kirim; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
                <div class="row">
                    {{ Form::open(['route' => 'print_transaksi']) }}
                    <input type="hidden" value="{{ $_GET['awal'] }}" name="tanggal_awal">
                    <input type="hidden" value="{{ $_GET['akhir'] }}" name="tanggal_akhir">
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary" target="_blank"><i class="fa fa-refresh fa-fw"></i> Print Laporan</button>
                    </div>
                    {{ Form::close() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra_js')

    {{ Html::script('admin_assets/component/datatables.net/js/jquery.dataTables.min.js') }}
    {{ Html::script('admin_assets/component/datatables.net-bs/js/dataTables.bootstrap.min.js') }}
    {{ Html::script('admin_assets/component/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}

    <script>
        $(document).ready(function() {
            $('#pesanan_selesai').DataTable({
                'lengthChange': false,
                'length': 10,
            })
            //Date picker
            $('#datepicker1').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            })
            $('#datepicker2').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            })
        })
    </script>

@endsection
