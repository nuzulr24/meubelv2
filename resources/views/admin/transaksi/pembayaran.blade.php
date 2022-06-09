@extends('admin.master')

@section('title', 'Manajemen Pembayaran')

@section('extra_css')

    {{ Html::style('admin_assets/component/datatables.net-bs/css/dataTables.bootstrap.min.css') }}

@endsection

@section('content-header')
<h1>
    Manajamen Pembayaran
    <small>Halaman manajemen segala pembayaran pesanan</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('beranda_admin') }}"><i class="fa fa-home"></i> Beranda</a></li>
    <li><i class="fa fa-money fa-fw"></i> pembayaran</li>
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
        <div class="box box-danger">
            <div class="box-header">
                <h3 class="box-title">
                    Table Pembayaran Yang Belum Di Verifikasi
                </h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-hover" id="table_pembayaran1">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Foto Bukti</th>
                            <th>Status Pembayaran</th>
                            <th>Tanggal Upload</th>
                            <th>Batas Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; ?>
                        @foreach ($data_pembayaran as $item)
                        @if($item->status_pembayaran == 0)
                            <?php $carbon = new Carbon\Carbon(); ?>
                            <?php $limit_check = $carbon::parse(explode(' ', $carbon::now())[0])->greaterThanOrEqualTo($carbon::parse($item->batas_pembayaran)) ?>
                            @if($limit_check && empty($item->foto_bukti))
                                <tr>
                                    <td id="id_{{ $counter }}">{{ $item->id_pesanan }}</td>
                                    <td><code>Expired</code></td>
                                    <td><code>Expired</code></td>
                                    <td><code>Expired</code></td>
                                    <td><code>Expired</code></td>
                                    <td><code>Expired</code></td>
                                </tr>
                            @else
                                <tr>
                                    <td id="id_{{ $counter }}">{{ $item->id_pesanan }}</td>
                                    <td>
                                        @if(!empty($item->foto_bukti))
                                            <button type="button" class="btn btn-warning btn-xs lihat_image" data-image="{{ $item->foto_bukti }}" data-toggle="modal" data-target="#lihat_foto" id="{{ $counter }}">
                                                <i class="fa fa-search fa-fw"></i> Lihat Foto Bukti
                                            </button>
                                        @else
                                            <span class="label label-warning">Belum Di Upload</span>
                                        @endif
                                    </td>
                                    <td><span class="label bg-gray">Belum Di Verifikasi</span></td>
                                    <td>
                                        @if(!empty($item->tanggal_upload))
                                            {{ $item->tanggal_upload  }}
                                        @else
                                            <span class="label label-warning">Belum Di Upload</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->batas_pembayaran }}</td>
                                    <td>
                                        <?php $check_pesanan = DB::table('tbl_pesanan')->where('id_pesanan', $item->id_pesanan)->first(); ?>
                                        @if(!empty($item->foto_bukti))
                                            @if($check_pesanan->dibatalkan == 0)
                                                <button type="button" class="btn btn-primary btn-xs proses_pembayaran" data-toggle="modal" data-target="#proses_pembayaran" id="{{ $counter }}">
                                                    <i class="fa fa-refresh fa-fw"></i> Proses Pembayaran
                                                </button>
                                            @else
                                            <span class="label label-danger">Pesanan Dibatalkan</span>
                                            @endif
                                        @else
                                            <span class="label label-warning">Belum Dapat Diproses</span>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endif
                        <?php $counter++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">
                    Table Pembayaran Yang Sudah Di Verifikasi
                </h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-hover" id="table_pembayaran2">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Foto Bukti</th>
                            <th>Status Pembayaran</th>
                            <th>Tanggal Upload</th>
                            <th>Batas Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; ?>
                        @foreach ($data_pembayaran as $item)
                            @if($item->status_pembayaran == 1)
                            <tr>
                                <td id="id_{{ $counter }}">{{ $item->id_pesanan }}</a>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-xs lihat_image" data-toggle="modal" data-image="{{ $item->foto_bukti }}" data-target="#lihat_foto" id="{{ $counter }}">
                                        <i class="fa fa-search fa-fw"></i> Lihat Foto Bukti
                                    </button>
                                </td>
                                <td><span class="label bg-green"><i class="fa fa-check fa-fw"></i> Terverifikasi</span></td>
                                <td>{{ $item->tanggal_upload  }}</td>
                                <td>{{ $item->batas_pembayaran }}</td>
                                <td>
                                    @if($item->status_pesanan >= 3)
                                        <span class="label bg-green"><i class="fa fa-check fa-fw"></i> Sudah Terkirim</span>
                                    @else
                                        <button type="button" class="btn btn-danger btn-xs proses_pembayaran" data-toggle="modal" data-target="#proses_pembayaran" id="{{ $counter }}">
                                            <i class="fa fa-close fa-fw"></i> Batalkan Verifikasi
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @endif
                        <?php $counter++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal modal-default fade" id="lihat_foto">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Foto bukti pembayaran</h4>
            </div>
            <div class="modal-body">
                {{ Html::image(null, null, ['class' => 'img-responsive', 'id' => 'foto_bukti']) }}
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal modal-default fade" id="proses_pembayaran">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Rubah Status Pembayaran ?</h4>
            </div>
            {!! Form::open(['method' => 'PUT', 'id' => 'form_proses_pembayaran']) !!}
                <div class="modal-footer">
                    <button type="button" class="btn pull-left" data-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan" value="true" class="btn btn-primary">
                        <i class="fa fa-refresh fa-fw"></i> Proses
                    </button>
                </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal modal-default fade" id="hapus_pembayaran">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Anda Yakin Ingin Lanjutkan ?</h4>
            </div>
            {!! Form::open(['method' => 'DELETE', 'id' => 'form_hapus_pembayaran']) !!}
                <div class="modal-footer">
                    <button type="button" class="btn pull-left" data-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan" value="true" class="btn btn-danger"><i class="fa fa-trash fa-fw"></i> Hapus pesanan</button>
                </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection

@section('extra_js')

    {{ Html::script('admin_assets/component/datatables.net/js/jquery.dataTables.min.js') }}
    {{ Html::script('admin_assets/component/datatables.net-bs/js/dataTables.bootstrap.min.js') }}

    <script>
        $(document).ready(function() {
            $('#table_pembayaran1').DataTable({
                'lengthChange': false,
                'length': 10,
            })
            $('#table_pembayaran2').DataTable({
                'lengthChange': false,
                'length': 10,
            })
        })
    </script>

@endsection
