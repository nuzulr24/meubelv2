@extends('admin.master')

@section('title', 'Manajemen Pesanan')

@section('extra_css')

    {{ Html::style('admin_assets/component/datatables.net-bs/css/dataTables.bootstrap.min.css') }}

@endsection

@section('content-header')
<h1>
    Manajamen Pesanan
    <small>Halaman manajemen segala pesanan</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('beranda_admin') }}"><i class="fa fa-home"></i> Beranda</a></li>
    <li><i class="fa fa-shopping-cart fa-fw"></i> pesanan</li>
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
                    Table Pesanan Yang Sedang Di Proses
                </h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-hover" id="table_pesanan_di_proses">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Nama Penerima</th>
                            <th>No Telepon</th>
                            <th>Status Pesanan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="values">
                        <?php $counter1 = 1; ?>
                        @foreach ($data_pesanan as $item)
                            @if($item->status_pesanan <= 1)
                            <tr>
                                <td id="id_{{ $counter1 }}">{{ $item->id_pesanan }}</td>
                                <td>{{ $item->nama_penerima  }}</td>
                                <td>{{ $item->no_telepon  }}</td>
                                <td>
                                    @if($item->dibatalkan == 0)
                                        <span class="label {{ $stat_label[$item->status_pesanan] }}">
                                            {{ $stat_notif[$item->status_pesanan] }}
                                        </span>
                                    @else
                                        <span class="label bg-red">
                                            Dibatalkan
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->dibatalkan == 0)
                                        <?php $carbon = new Carbon\Carbon(); ?>
                                        <?php //$limit_check = $carbon::parse(explode(' ', $carbon::now())[0])->greaterThanOrEqualTo($carbon::parse($item->batas_pembayaran)) ?>
                                        {{-- @if($limit_check && !is_null($item->foto_bukti)) --}}
                                        @if($carbon::parse(explode(' ', $carbon::now())[0])->lessThanOrEqualTo($carbon::parse($item->batas_pembayaran)))
                                            @if($item->status_pesanan == 1)
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
                                                        Action <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a href="{{ route('detail_pesanan_admin', [$item->id_pesanan]) }}"><i class="fa fa-user fa-fw"></i> Detail pesanan</a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="proses_pesanan" data-toggle="modal" data-target="#proses_pesanan" id="{{ $counter1 }}">
                                                                <i class="fa fa-refresh fa-fw"></i> Proses Pesanan
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="edit_pesanan" data-toggle="modal" data-target="#edit_pesanan" id="{{ $counter1 }}">
                                                                <i class="fa fa-trash fa-fw"></i> Rubah Data Penerima
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="batalkan_pesanan" data-toggle="modal" data-target="#batalkan_pesanan" id="{{ $counter1 }}">
                                                                <i class="fa fa-ban fa-fw"></i> Batalkan pesanan
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="hapus_pesanan" data-toggle="modal" data-target="#hapus_pesanan" id="{{ $counter1 }}">
                                                                <i class="fa fa-trash fa-fw"></i> Hapus pesanan
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @else
                                                <span class="label bg-yellow">Menunggu Pembayaran</span>
                                                    <a href="#" class="batalkan_pesanan" data-toggle="modal" data-target="#batalkan_pesanan" id="{{ $counter1 }}">
                                                        <span class="label label-danger"><i class="fa fa-ban fa-fw"></i> Batalkan</span>
                                                    </a>
                                            @endif
                                        @else
                                            <span class="label bg-red">Expired</span>
                                            <a href="#" class="label bg-red hapus_pesanan" data-toggle="modal" data-target="#hapus_pesanan" id="{{ $counter1 }}">
                                                <i class="fa fa-trash fa-fw"></i> Hapus
                                            </a>
                                        @endif
                                    @else
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown">
                                                Action <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="{{ route('detail_pesanan_admin', [$item->id_pesanan]) }}"><i class="fa fa-user fa-fw"></i> Detail pesanan</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="batalkan_pesanan" data-toggle="modal" data-target="#batalkan_pesanan" id="{{ $counter1 }}">
                                                        <i class="fa fa-reply fa-fw"></i> Cabut Status Batal
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="hapus_pesanan" data-toggle="modal" data-target="#hapus_pesanan" id="{{ $counter1 }}">
                                                        <i class="fa fa-trash fa-fw"></i> Hapus pesanan
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endif
                        <?php $counter1++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">
                    Table Pesanan Yang Siap Di Kirim
                </h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-hover" id="table_pesanan_siap_kirim">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Nama Penerima</th>
                            <th>No Telepon</th>
                            <th>Layanan</th>
                            <th>Status Pesanan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter2 = 1; ?>
                        @foreach ($data_pesanan as $item)
                            @if($item->status_pesanan == 2)
                            <tr>
                                <td id="id_{{ $counter2 }}">{{ $item->id_pesanan }}</td>
                                <td>{{ $item->nama_penerima  }}</td>
                                <td>{{ $item->no_telepon  }}</td>
                                <td>{{ strtoupper($item->kurir) }} ({{ $item->kurir === "cod" ? strtoupper($item->kurir_cod) : strtoupper($item->kurir) }})</td>
                                <td>
                                    <span class="label {{ $stat_label[$item->status_pesanan] }}">
                                        {{ $stat_notif[$item->status_pesanan] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route('detail_pesanan_admin', [$item->id_pesanan]) }}"><i class="fa fa-user fa-fw"></i> Detail pesanan</a>
                                            </li>
                                            <li>
                                                <a href="#" class="kirim_pesanan" data-toggle="modal" data-target="#kirim_pesanan" id="{{ $counter2 }}">
                                                    <i class="fa fa-truck fa-fw"></i> Kirim Pesanan
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="proses_pesanan" data-toggle="modal" data-target="#proses_pesanan" id="{{ $counter2 }}">
                                                    <i class="fa fa-trash fa-fw"></i> Batal Proses
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endif
                        <?php $counter2++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('modal')
<div class="modal modal-default fade" id="kirim_pesanan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Kirim Pesanan</h4>
            </div>
            {!! Form::open(['method' => 'PUT', 'id' => 'form_kirim_pesanan']) !!}
                <div class="modal-body">
                    <div class="form-group">
                        {{ Form::label('inp_resi', 'Jenis Ekspedisi') }}
                        <select class="form-control" name="kurir_cod">
                            <option value="">-- pilih salah satu --</option>
                            <?php
                                foreach(DB::table('tbl_kurir')->get() as $kr){
                                    $kurir = explode("|", DB::table('tbl_website')->where('id', 19)->value('value'));
                                    if(in_array($kr->id, $kurir)){
                                        if($kr->rajaongkir == "cod")
                                        {

                                        } else {
                                            echo '<option value="'.$kr->rajaongkir.'">'.$kr->nama.'</option>';
                                        }
                                    }
                                }
                            ?>
                        </select>
                        <p class="small my-2">silahkan pilih expedisi jika paket anda COD.</p>
                    </div>
                    <div class="form-group">
                        {{ Form::label('inp_resi', 'Input Resi Pesanan') }}
                        {{ Form::text('resi', null, ['id' => 'inp_resi', 'class' => 'form-control']) }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn pull-left" data-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan" value="true" class="btn btn-success"><i class="fa fa-paper-plane fa-fw"></i> Kirim pesanan</button>
                </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal modal-default fade" id="edit_pesanan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Rubah Informasi Penerima</h4>
            </div>
            {!! Form::open(['method' => 'PUT', 'id' => 'form_edit_pesanan']) !!}
                <div class="modal-body">
                    <div class="form-group">
                        {{ Form::label('inp_nama_penerima', 'Nama Penerima') }}
                        {{ Form::text('nama_penerima', null, ['id' => 'inp_nama_penerima', 'class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('inp_alamat_tujuan', 'Alamat Tujuan') }}
                        {{ Form::textarea('alamat_tujuan', null, ['id' => 'inp_alamat_tujuan', 'class' => 'form-control', 'rows' => 5]) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('inp_no_telepon', 'No. Telepon') }}
                        {{ Form::text('no_telepon', null, ['id' => 'inp_no_telepon', 'class' => 'form-control']) }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn pull-left" data-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan" value="true" class="btn btn-primary"> Simpan Perubahan</button>
                </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal modal-default fade" id="proses_pesanan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Proses Pesanan ?</h4>
            </div>
            {!! Form::open(['method' => 'PUT', 'id' => 'form_proses_pesanan']) !!}
                <div class="modal-footer">
                    <button type="button" class="btn pull-left" data-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan" value="true" class="btn btn-primary"><i class="fa fa-refresh fa-fw"></i> Proses pesanan</button>
                </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal modal-default fade" id="batalkan_pesanan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Ganti Status Pembatalan Pesanan ?</h4>
            </div>
            {!! Form::open(['method' => 'PUT', 'id' => 'form_batalkan_pesanan']) !!}
                <div class="modal-footer">
                    <button type="button" class="btn pull-left" data-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan" value="true" class="btn btn-primary"><i class="fa fa-refresh fa-fw"></i> Proses</button>
                </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal modal-default fade" id="hapus_pesanan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Anda Yakin Ingin Menghapus Pesanan ?</h4>
            </div>
            {!! Form::open(['method' => 'DELETE', 'id' => 'form_hapus_pesanan']) !!}
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
            $('#table_pesanan_di_proses').DataTable({
                'lengthChange': false,
                'length': 10,
            })
            $('#table_pesanan_siap_kirim').DataTable({
                'lengthChange': false,
                'length': 10,
            })
        })
    </script>

@endsection
