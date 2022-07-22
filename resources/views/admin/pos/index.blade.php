@extends('admin.master')

@section('title', 'Point of Sales')

@section('extra_css')

    {{ Html::style('admin_assets/component/datatables.net-bs/css/dataTables.bootstrap.min.css') }}

@endsection

@section('content-header')
<h1>
    Point of Sales
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('beranda_admin') }}"><i class="fa fa-home"></i> Beranda</a></li>
    <li><i class="fa fa-cubes fa-fw"></i> Transaksi</li>
    <li class="active"><i class="fa fa-clipboard fa-fw"></i> Point of Sales</li>
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
                    Tambah Transaksi
                </h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                {!! Form::open(['route' => 'checkout', 'files' => true]) !!}
                    @csrf
                    <div class="box-body">
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_nama_kategori', 'Barang') !!}
                            <select name="id_produk" id="id_produk" class="form-control">
                                <option>-- pilih salah satu --</option>
                                <?php $counter_kategori = 1; ?>
                                @foreach (DB::table('tbl_barang')->get() as $item)
                                    <option value="{{ $item->id_barang }}" data-harga="{{ $item->harga_satuan }}">{{ $item->nama_barang }} / {{ 'Rp. ' . number_format($item->harga_satuan, 2) }}</option>
                                <?php $counter_kategori++; ?>
                                @endforeach
                            </select>
                            <span class="help-block"><small>Silahkan pilih produk yang ingin dipesan</small></span>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_nama_kategori', 'Tipe Transaksi') !!}
                            <select name="tipe_barang" class="form-control" id="tipe_barang">
                                <option value="">-- pilih salah satu --</option>
                                <option value="Transaksi Masuk">Transaksi Masuk</option>
                                <option value="Transaksi Keluar">Transaksi Keluar</option>
                            </select>
                            <span class="help-block">Silahkan pilih tipe transaksi</span>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_nama_kategori', 'Jumlah') !!}
                            <input type="number" class="form-control jumlah" name="jumlah">
                            <span class="help-block">Silahkan masukan jumlah pesan</span>
                        </div>
                        <div class="text-right">
                            <h4 style="font-weight: bold">Harga Total<h4>
                            <p id="harga"></p>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="form-group has-feedback">
                            <button type="submit" value="simpan" class="btn btn-primary btn-flat btn-block form-control">Pesan</button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">
                    Daftar Pesanan
                </h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-hover" id="table_kategori">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>ID Pengguna</th>
                            <th>Nama Produk</th>
                            <th>Jenis Transaksi</th>
                            <th>Jumlah</th>
                            <th>Total Bayar</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; 
                            if(session('superadmin') == 1)
                            {
                                $query = DB::table('tbl_transaction')->get();
                            } else {
                                $query = DB::table('tbl_transaction')->where('id_pengguna', session('id_admin'))->get();
                            }
                        ?>
                        @foreach ($query as $item)
                        <?php $product = DB::table('tbl_barang')->where('id_barang', $item->id_product)->value('nama_barang'); ?>
                            <tr>
                                <td id="id_{{ $counter }}">{{ $item->id_pesanan }}</td>
                                <td id="pengguna_{{ $counter }}">{{ $item->id_pengguna  }}</td>
                                <td id="nama_{{ $counter }}">{{ $product }}</td>
                                <td id="type_{{ $counter }}">{{ $item->type }}</td>
                                <td id="qty_{{ $counter }}">{{ $item->qty }}</td>
                                <td id="total_{{ $counter }}">{{ 'Rp '. number_format($item->total_bayar, 2) }}</td>
                                <td id="total_{{ $counter }}">{{ $item->created_at }}</td>
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
    <div class="modal modal-default fade" id="edit_pos">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit</h4>
                </div>
                {!! Form::open(['id' => 'form_edit_pos', 'method' => 'PUT', 'files' => true]) !!}
                    <div class="modal-body">
                        @csrf
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_edit_stok_barang', 'Qty') !!}
                            {!! Form::number('qty',  null, ['id' => 'inp_edit_qty', 'class' => 'form-control qty']) !!}
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
    <div class="modal modal-default fade" id="hapus_pesanan">
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