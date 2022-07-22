@extends('admin.master')

@section('title', 'Kategori Produk')

@section('extra_css')

    {{ Html::style('admin_assets/component/datatables.net-bs/css/dataTables.bootstrap.min.css') }}

@endsection

@section('content-header')
<h1>
    Manajemen Stok
    <small>Halaman manajemen stok pada produk</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('beranda_admin') }}"><i class="fa fa-home"></i> Beranda</a></li>
    <li><i class="fa fa-cubes fa-fw"></i> Produk</li>
    <li class="active"><i class="fa fa-clipboard fa-fw"></i> Stok</li>
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
                    Form Input Stok Barang
                </h3>
            </div>
            {!! Form::open(['route' => 'tambah_stok', 'files' => true]) !!}
                @csrf
                <div class="box-body">
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_nama_kategori', 'Nama Barang') !!}
                        {!! Form::text('nama_kategori', null, ['id' => 'inp_nama_kategori', 'class' => 'form-control']) !!}
                        <span class="help-block">Silahkan masukan kategori produk</span>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_nama_kategori', 'Tipe Barang') !!}
                        <select name="tipe_barang" class="form-control" id="">
                            <option value="">-- pilih salah satu --</option>
                            <option value="Barang Mentah">Barang Mentah</option>
                            <option value="Barang Setengah Jadi">Barang Setengah Jadi</option>
                            <option value="Barang Jadi">Barang Jadi</option>
                        </select>
                        <span class="help-block">Silahkan pilih tipe barang</span>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_nama_kategori', 'Jumlah Stok Barang') !!}
                        <input type="number" class="form-control" name="jumlah_stok">
                        <span class="help-block">Silahkan masukan jumlah stok barang</span>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="form-group has-feedback">
                        <button type="submit" value="simpan" class="btn btn-primary btn-flat btn-block form-control">Simpan</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">
                    Table Stok
                </h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-hover" id="table_kategori">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Tipe Barang</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; ?>
                        @foreach ($data_stok as $item)
                            <tr>
                                <td id="id_{{ $counter }}">{{ $item->id }}</td>
                                <td id="nama_{{ $counter }}">{{ $item->nama  }}</td>
                                <td id="tipe_{{ $counter }}">{{ $item->tipe_stok  }}</td>
                                <td id="stok_{{ $counter }}">{{ $item->jumlah_stok  }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="#" class="edit_stok" data-toggle="modal" data-target="#edit_stok" id="{{ $counter }}">
                                                    <i class="fa fa-edit fa-fw"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="pindah_produk" data-toggle="modal" data-target="#pindah_produk" id="{{ $counter }}">
                                                    <i class="fa fa-arrow-right fa-fw"></i> Pindah ke Produk
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="hapus_stok" data-toggle="modal" data-target="#hapus_stok" id="{{ $counter }}">
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
<div class="modal modal-default fade" id="edit_stok">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Stok Barang</h4>
            </div>
            {!! Form::open(['id' => 'form_edit_stok', 'method' => 'PUT', 'files' => true]) !!}
                <div class="modal-body">
                    <div class="form-group has-feedback">
                        {!! Form::label('text_id_kategori', 'ID Barang') !!}
                        {!! Form::text('id_kategori', null, ['class' => 'form-control id_kategori', 'disabled' => '']) !!}
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_nama_kategori_produk', 'Nama Barang') !!}
                        {!! Form::text('nama_kategori', null, ['class' => 'form-control nama_kategori']) !!}
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_stok_produk', 'Jumlah Stok Barang') !!}
                        {!! Form::text('jumlah_stok', null, ['class' => 'form-control jumlah_stok']) !!}
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

<div class="modal modal-default fade" id="pindah_produk">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pindah Stok ke Produk</h4>
            </div>
            {!! Form::open(['id' => 'form_edit_pindah', 'method' => 'PUT', 'files' => true]) !!}
                <div class="modal-body">
                    <div class="form-group has-feedback">
                        {!! Form::label('text_id_kategori', 'ID Stok') !!}
                        {!! Form::text('id_kategori', null, ['class' => 'form-control id_kategori', 'disabled' => '']) !!}
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_nama_kategori_produk', 'Nama Barang') !!}
                        {!! Form::text('nama_kategori', null, ['class' => 'form-control nama_kategori']) !!}
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_edit_id_kategori', 'Pilih Kategori Produk') !!}
                        <select name="id_kategori" id="inp_edit_id_kategori" class="form-control">
                            <option>-- PILIH KATEGORI --</option>
                            <?php $counter_kategori = 1; ?>
                            @foreach (DB::table('tbl_kategori')->get() as $item)
                                <option value="{{ $item->id_kategori }}" id="kategori_{{ $counter_kategori }}" class="edit_kategori">{{ $item->nama_kategori }}</option>
                            <?php $counter_kategori++; ?>
                            @endforeach
                        </select>
                        <span class="help-block"><small>Silahkan pilih kategori produk yang sesuai</small></span>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_edit_id_merk', 'Pilih Merk Produk') !!}
                        <select name="id_merk" id="inp_edit_id_merk" class="form-control">
                            <option> -- PILIH MERK --</option>
                            <?php $counter_merk = 1; ?>
                            @foreach (DB::table('tbl_merk')->get()  as $item)
                            <option value="{{ $item->id_merk }}" id="merk_{{ $counter_merk }}" class="edit_kategori">{{ $item->nama_merk }}</option>
                            <?php $counter_merk++; ?>
                            @endforeach
                        </select>
                        <span class="help-block"><small>Silahkan pilih merk produk yang sesuai</small></span>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_nama_kategori_produk', 'Nama Barang') !!}
                        {!! Form::text('nama_kategori', null, ['class' => 'form-control nama_kategori']) !!}
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_nama_kategori_produk', 'Harga Satuan Barang') !!}
                        {!! Form::text('harga', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn pull-left" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Pindah</button>
                </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<div class="modal modal-default fade" id="hapus_stok">
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