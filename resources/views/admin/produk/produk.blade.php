@extends('admin.master')

@section('title', 'Produk')

@section('extra_css')

    {{ Html::style('admin_assets/component/datatables.net-bs/css/dataTables.bootstrap.min.css') }}

@endsection

@section('content-header')
<h1>
    Manajemen Produk
    <small>Halaman manajemen produk</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('beranda_admin') }}"><i class="fa fa-home"></i> Beranda</a></li>
    <li class="active"><i class="fa fa-cubes fa-fw"></i> Produk</li>
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
        <div class="box box-primary collapsed-box">
            <div class="box-header">
                <h3 class="box-title">
                    Form Input Produk
                </h3>
                <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-plus"></i>
                </button>
                </div>
            </div>
            <div class="box-body row">
                {!! Form::open(['route' => 'tambah_produk', 'files' => true]) !!}
                @csrf
                <div class="col-sm-6">
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_nama_barang', 'Nama Produk') !!}
                        {!! Form::text('nama_barang',  null, ['id' => 'inp_nama_barang', 'class' => 'form-control']) !!}
                        <span class="help-block"><small>Masukan nama produk tanpa karakter khusus dan angka</small></span>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_id_kategori', 'Pilih Kategori Produk') !!}
                        <select name="id_kategori" id="inp_id_kategori" class="form-control">
                            <option>=== PILIH KATEGORI ===</option>
                            @foreach ($data_kategori as $item)
                                <option value="{{ $item->id_kategori }}">{{ $item->nama_kategori }}</option>
                            @endforeach
                        </select>
                        <span class="help-block"><small>Silahkan pilih kategori produk yang sesuai</small></span>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_id_merk', 'Pilih Merk Produk') !!}
                        <select name="id_merk" id="inp_id_merk" class="form-control">
                            <option> === PILIH MERK ===</option>
                            @foreach ($data_merk as $item)
                                <option value="{{ $item->id_merk }}">{{ $item->nama_merk }}</option>
                            @endforeach
                        </select>
                        <span class="help-block"><small>Silahkan pilih merk produk yang sesuai</small></span>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_deskripsi_barang', 'Deskripsi Barang') !!}
                        {!! Form::textarea('deskripsi_barang', null, ['id' => 'inp_deskripsi_barang', 'class' => 'form-control']) !!}
                        <span class="help-block"><small>Silahkan Masukan Deskripsi Produk</small></span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_berat_barang', 'Berat Barang @gram') !!}
                        {!! Form::number('berat_barang',  null, ['id' => 'inp_berat_barang', 'class' => 'form-control']) !!}
                        <span class="help-block"><small>Silahkan masukan berat barang dengan satuan gram</small></span>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_harga_satuan', 'Harga Satuan') !!}
                        {!! Form::number('harga_satuan',  null, ['id' => 'inp_harga_satuan', 'class' => 'form-control']) !!}
                        <span class="help-block"><small>Silahkan masukan harga satuan produk tanpa karakter khusus dan alphabet</small></span>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_stok_barang', 'Stok Barang') !!}
                        {!! Form::number('stok_barang',  null, ['id' => 'inp_stok_barang', 'class' => 'form-control']) !!}
                        <span class="help-block"><small>Silahkan masukan stok produk yanpa karakter khusus dan alphabet</small></span>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_foto_barang', 'Foto Product') !!}
                        {!! Form::file('foto_barang', ['id' => 'inp_foto_barang', 'class' => 'form-control' , 'style' => 'border: none;', 'accept' => '.jpg, .jpeg, .png']) !!}
                        <span class="help-block"><small>Silahkan pilih foto product</small></span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group has-feedback">
                        <button type="submit" id="simpan" name="simpan" value="true" class="btn btn-primary btn-flat pull-right">Simpan Produk</button>
                        <button type="reset" class="btn btn-danger btn-flat">Batal</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">
                    Table Produk
                </h3>
            </div>
            <div class="box-body">
                {{ Form::open(['method' => 'GET']) }}
                <div class="form-group">
                    <label>Filter Data Produk</label>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="kategori" class="form-control">
                                <option value>Pilih Kategori...</option>
                                @foreach ($data_kategori as $item)
                                <option value="{{ $item->nama_kategori }}">{{ $item->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="merk" class="form-control">
                                <option value>Pilih Merk...</option>
                                @foreach ($data_merk as $item)
                                <option value="{{ $item->nama_merk }}">{{ $item->nama_merk }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="submit" class="btn btn-warning">Filter</button>
                            <a class="btn btn-primary" href="{{ route('list_produk') }}">Reset</a>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
                <table class="table table-bordered table-hover" id="table_produk">
                    <thead>
                        <tr>
                            <th>ID Produk</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Merk</th>
                            <th>Status</th>
                            <th>Tanggal Masuk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; ?>
                        @foreach ($data_produk as $item)
                            <tr>
                                <td id="id_{{ $counter }}">{{ $item->id_barang }}</td>
                                <td id="nama_{{ $counter }}">{{ $item->nama_barang  }}</td>
                                <td id="kategori_{{ $counter }}">{{ $item->nama_kategori  }}</td>
                                <td id="merk_{{ $counter }}">{{ $item->nama_merk  }}</td>
                                <td>
                                    @if($item->stok_barang > 0)
                                        <span class="label bg-green"><i class="fa fa-check fa-fw"></i> Tersedia</span>
                                    @else
                                        <span class="label bg-red"><i class="fa fa-close fa-fw"></i> Tersedia</span>
                                    @endif
                                </td>
                                <td id="tanggal_{{ $counter }}">{{ $item->tanggal_masuk  }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="#" class="edit_produk" data-toggle="modal" data-target="#edit_produk" id="{{ $counter }}">
                                                    <i class="fa fa-edit fa-fw"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="hapus_produk" data-toggle="modal" data-target="#hapus_produk" id="{{ $counter }}">
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
<div class="modal modal-default fade" id="edit_produk">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Produk</h4>
            </div>
            {!! Form::open(['id' => 'form_edit_produk', 'method' => 'PUT', 'files' => true]) !!}
                <div class="modal-body row">
                    @csrf
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_edit_nama_barang', 'Nama Produk') !!}
                            {!! Form::text('nama_barang',  null, ['id' => 'inp_edit_nama_barang', 'class' => 'form-control']) !!}
                            <span class="help-block"><small>Masukan nama produk tanpa karakter khusus dan angka</small></span>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_edit_id_kategori', 'Pilih Kategori Produk') !!}
                            <select name="id_kategori" id="inp_edit_id_kategori" class="form-control">
                                <option>=== PILIH KATEGORI ===</option>
                                <?php $counter_kategori = 1; ?>
                                @foreach ($data_kategori as $item)
                                    <option value="{{ $item->id_kategori }}" id="kategori_{{ $counter_kategori }}" class="edit_kategori">{{ $item->nama_kategori }}</option>
                                <?php $counter_kategori++; ?>
                                @endforeach
                            </select>
                            <span class="help-block"><small>Silahkan pilih kategori produk yang sesuai</small></span>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_edit_id_merk', 'Pilih Merk Produk') !!}
                            <select name="id_merk" id="inp_edit_id_merk" class="form-control">
                                <option> === PILIH MERK ===</option>
                                <?php $counter_merk = 1; ?>
                                @foreach ($data_merk as $item)
                                <option value="{{ $item->id_merk }}" id="merk_{{ $counter_merk }}" class="edit_kategori">{{ $item->nama_merk }}</option>
                                <?php $counter_merk++; ?>
                                @endforeach
                            </select>
                            <span class="help-block"><small>Silahkan pilih merk produk yang sesuai</small></span>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_edit_foto_barang', 'Foto Product') !!}
                            {!! Form::file('foto_barang', ['id' => 'inp_edit_foto_barang', 'class' => 'form-control' , 'style' => 'border: none;', 'accept' => '.jpg, .jpeg, .png']) !!}
                            <span class="help-block"><small>Silahkan pilih foto product</small></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_edit_berat_barang', 'Berat Barang @gram') !!}
                            {!! Form::number('berat_barang',  null, ['id' => 'inp_edit_berat_barang', 'class' => 'form-control']) !!}
                            <span class="help-block"><small>Silahkan masukan berat barang dengan satuan gram</small></span>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_edit_harga_satuan', 'Harga Satuan') !!}
                            {!! Form::number('harga_satuan',  null, ['id' => 'inp_edit_harga_satuan', 'class' => 'form-control']) !!}
                            <span class="help-block"><small>Silahkan masukan harga satuan produk tanpa karakter khusus dan alphabet</small></span>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_edit_stok_barang', 'Stok Barang') !!}
                            {!! Form::number('stok_barang',  null, ['id' => 'inp_edit_stok_barang', 'class' => 'form-control']) !!}
                            <span class="help-block"><small>Silahkan masukan stok produk yanpa karakter khusus dan alphabet</small></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_edit_deskripsi_barang', 'Deskripsi Barang') !!}
                            {!! Form::textarea('deskripsi_barang', null, ['id' => 'inp_edit_deskripsi_barang', 'class' => 'form-control']) !!}
                            <span class="help-block"><small>Silahkan Masukan Deskripsi Produk</small></span>
                        </div>
                        <h3 class="text-center">Foto Produk</h3>
                        {{ Html::image(null, null, ['id' => 'foto_barang', 'class' => 'img-responsive', 'style' => 'margin: 0 auto;']) }}
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
<div class="modal modal-default fade" id="hapus_produk">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Anda Yakin Ingin Lanjutkan ?</h4>
                </div>
                {!! Form::open(['id' => 'form_hapus_produk', 'method' => 'DELETE']) !!}
                    <div class="modal-footer">
                        @csrf
                        <button type="button" class="btn pull-left" data-dismiss="modal">Batal</button>
                        <button type="submit" name="simpan" value="true" class="btn btn-danger">Hapus Produk</button>
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
    {{ Html::script('admin_assets/component/ckeditor/ckeditor.js') }}

    <script>
        $(document).ready(function() {
            $('#table_produk').DataTable({
                'lengthChange': false,
                'length': 10,
            })
        })
        CKEDITOR.replace('inp_deskripsi_barang')
        CKEDITOR.replace('inp_edit_deskripsi_barang')

    </script>

@endsection
