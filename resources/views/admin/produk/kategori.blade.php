@extends('admin.master')

@section('title', 'Kategori Produk')

@section('extra_css')

    {{ Html::style('admin_assets/component/datatables.net-bs/css/dataTables.bootstrap.min.css') }}

@endsection

@section('content-header')
<h1>
    Manajemen Kategori
    <small>Halaman manajemen kategori pada prooduk</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('beranda_admin') }}"><i class="fa fa-home"></i> Beranda</a></li>
    <li><i class="fa fa-cubes fa-fw"></i> Produk</li>
    <li class="active"><i class="fa fa-clipboard fa-fw"></i> Kategori</li>
</ol>
@endsection

@section('content')

<div class="row">
    <div class="col-md-6 col-sm-12">
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
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">
                    Form Input Kategori Produk
                </h3>
            </div>
            {!! Form::open(['route' => 'tambah_kategori']) !!}
                @csrf
                <div class="box-body">
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_nama_kategori', 'Nama Kategori') !!}
                        {!! Form::text('nama_kategori', null, ['id' => 'inp_nama_kategori', 'class' => 'form-control']) !!}
                        <span class="help-block">Silahkan masukan kategori produk</span>
                    </div>
                    <div class="form-group has-feedback">
                        <button type="button" id="check_kategori" class="btn btn-success btn-flat btn-block" class="form-control"><i class="fa fa-search fa-fw"></i> Check Nama kategori</button>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="form-group has-feedback">
                        <button type="button" id="simpan" name="simpan" value="true" class="btn btn-primary btn-flat btn-block form-control disabled">Simpan kategori</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">
                    Table Kategori
                </h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-hover" id="table_kategori">
                    <thead>
                        <tr>
                            <th>ID Kategori</th>
                            <th>Nama Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; ?>
                        @foreach ($data_kategori as $item)
                            <tr>
                                <td id="id_{{ $counter }}">{{ $item->id_kategori }}</td>
                                <td id="nama_{{ $counter }}">{{ $item->nama_kategori  }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="#" class="edit_kategori" data-toggle="modal" data-target="#edit_kategori" id="{{ $counter }}">
                                                    <i class="fa fa-edit fa-fw"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="hapus_kategori" data-toggle="modal" data-target="#hapus_kategori" id="{{ $counter }}">
                                                    <i class="fa fa-trash fa-fw"></i> Hapus
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
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
<div class="modal modal-default fade" id="edit_kategori">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Kategori Produk</h4>
            </div>
            {!! Form::open(['id' => 'form_edit_kategori', 'method' => 'PUT']) !!}
                <div class="modal-body">
                    <div class="form-group has-feedback">
                        {!! Form::label('text_id_kategori', 'ID Kategori') !!}
                        {!! Form::text('id_kategori', null, ['class' => 'form-control id_kategori', 'disabled' => '']) !!}
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_nama_kategori_produk', 'Nama Kategori Produk') !!}
                        {!! Form::text('nama_kategori', null, ['class' => 'form-control nama_kategori']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn pull-left" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="simpan" value="true" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal modal-default fade" id="hapus_kategori">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Anda Yakin Ingin Lanjutkan ?</h4>
                </div>
                {!! Form::open(['id' => 'form_hapus_kategori', 'method' => 'DELETE']) !!}
                    <div class="modal-footer">
                        <button type="button" class="btn pull-left" data-dismiss="modal">Batal</button>
                        <button type="submit" name="simpan" value="true" class="btn btn-danger"><i class="fa fa-trash fa-fw"></i> Hapus Kategori</button>
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
            $('#table_kategori').DataTable({
                'lengthChange': false,
                'length': 10,
                'searching': false
            })
        })
    </script>

@endsection