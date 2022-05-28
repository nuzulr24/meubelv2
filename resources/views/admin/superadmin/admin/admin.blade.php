@extends('admin.master')

@section('title', 'Manajemen Admin')

@section('extra_css')

    {{ Html::style('admin_assets/component/datatables.net-bs/css/dataTables.bootstrap.min.css') }}

    <style>
    .profile-user-img {
        margin: 0 auto;
        width: 200px;
        padding: 3px;
        border: 3px solid #d2d6de;
    }
    </style>

@endsection

@section('content-header')
<h1>
    Manajamen Akun Admin
    <small>Halaman manajemen akun admin</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('beranda_admin') }}"><i class="fa fa-home"></i> Beranda</a></li>
    <li><i class="fa fa-terminal fa-fw"></i> Superadmin</li>
    <li class="active"><i class="fa fa-users fa-fw"></i> Admin</li>
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
                    Table Akun Admin
                </h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-primary btn-sm btn-flat" data-toggle="modal" data-target="#tambah_admin">
                        <i class="fa fa-plus fa-fw"></i> Buat Akun Admin
                    </button>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-hover" id="table_admin">
                    <thead>
                        <tr>
                            <th>ID Admin</th>
                            <th>Nama Admin</th>
                            <th>SuperAdmin</th>
                            <th>Status Blokir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; ?>
                        @foreach ($data_admin as $item)
                            <tr>
                                <td id="id_{{ $counter }}">{{ $item->id_admin }}</td>
                                <td>{{ $item->nama_lengkap  }}</td>
                                <td>
                                    @if ($item->superadmin == true)
                                        <span class="label bg-green"><i class="fa fa-check fa-fw"></i> SuperAdmin</span>
                                    @else
                                        <span class="label bg-red"><i class="fa fa-close fa-fw"></i> SuperAdmin</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->diblokir == true)
                                        <span class="label bg-green"><i class="fa fa-check fa-fw"></i> Ya</span>
                                    @else
                                        <span class="label bg-red"><i class="fa fa-close fa-fw"></i> Tidak</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="#" class="detail_admin" data-toggle="modal" data-target="#detail_admin" id="{{ $counter }}">
                                                    <i class="fa fa-user fa-fw"></i> Detail Akun
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ url('admin/edit_user/s', $item->id_admin) }}">
                                                    <i class="fa fa-user fa-fw"></i> Edit Akun
                                                </a>
                                            </li>
                                            @if(session('id_admin') != $item->id_admin)
                                            <li>
                                                <a href="#" class="hapus_admin" data-toggle="modal" data-target="#hapus_admin" id="{{ $counter }}">
                                                    <i class="fa fa-trash fa-fw"></i> Hapus Akun
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="ubah_status_admin" data-toggle="modal" data-target="#ubah_status_admin" id="{{ $counter }}">
                                                    <i class="fa fa-info-circle fa-fw"></i> Ubah Status Akun
                                                </a>
                                            </li>
                                                @if($item->diblokir)
                                                    <li>
                                                        <a href="{{ route('blokir', ['id_admin' => $item->id_admin]) }}">
                                                            <i class="fa fa-unlock fa-fw"></i> Lepas Blokir
                                                        </a>
                                                    </li>
                                                @else
                                                    <li>
                                                        <a href="{{ route('blokir', ['id_admin' => $item->id_admin]) }}">
                                                            <i class="fa fa-lock fa-fw"></i> Blokir Akun
                                                        </a>
                                                    </li>
                                                @endif
                                            @endif
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
<div class="modal modal-default fade" id="tambah_admin">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah Admin</h4>
            </div>
            {!! Form::open(['route' => 'tambah_admin', 'id' => 'form_tambah_admin', 'files' => true]) !!}
                <div class="modal-body row">
                    @csrf
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_nama_admin', 'Nama Lengkap Admin') !!}
                            {!! Form::text('nama_lengkap',  null, ['id' => 'inp_nama_admin', 'class' => 'form-control']) !!}
                            <span class="help-block"><small>Masukan nama tanpa karakter khusus dan angka</small></span>
                        </div>
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_foto_admin', 'Foto Admin') !!}
                            {!! Form::file('foto', ['id' => 'inp_foto_admin', 'class' => 'form-control' , 'style' => 'border: none;', 'accept' => '.jpg, .jpeg, .png']) !!}
                            <span class="help-block"><small>Silahkan pilih foto admin</small></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            {!! Form::label('inp_email_aktif', 'Email Aktif') !!}
                            {!! Form::email('email',  null, ['id' => 'inp_email_aktif', 'class' => 'form-control']) !!}
                            <span class="help-block"><small>Silahkan masukan email aktif </small></span>
                        </div>

                        <div class="form-group has-feedback">
                            {!! Form::label('inp_password', 'Password Sementara') !!}
                            {!! Form::password('password', ['id' => 'inp_password', 'class' => 'form-control']) !!}
                            <span class="help-block"><small>Silahkan masukan password admin tanpa karakter khusus</small></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn pull-left" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="simpan" value="true" class="btn btn-primary">Simpan Data Admin</button>
                </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal modal-default fade" id="detail_admin">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body row">
                <div class="col-md-6">
                    <h4 class="text-center">Foto Admin</h4>
                    <img src="" id="foto" class="profile-user-img img-responsive img-circle">
                </div>
                <div class="col-md-6">
                    <h4>Nama Lengkap</h4>
                    <p class="text-muted" id="nama_lengkap"></p>
                    <h4>SuperAdmin</h4>
                    <p><span class="label" id="superadmin"></span></p>
                    <h4>Alamat Email</h4>
                    <p class="text-muted" id="email"></p>
                    <h4>Status Blokir</h4>
                    <p><span class="label" id="blokir"></span></p>
                    <h4>Tanggal Bergabung</h4>
                    <p class="text-muted" id="tanggal"></p>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal modal-default fade" id="ubah_status_admin">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Ubah Status Admin</h4>
            </div>
            {!! Form::open(['method' => 'PUT', 'id' => 'form_edit_status_admin']) !!}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inp_edit_status_admin">Status Admin</label>
                        <select name="superadmin" class="form-control" id="inp_edit_status_admin">
                            <option value="1">Superadmin</option>
                            <option value="0">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn pull-left" data-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan" value="true" class="btn btn-primary">
                        <i class="fa fa-refresh fa-fw"></i> Ganti Status admin
                    </button>
                </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal modal-default fade" id="hapus_admin">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Anda Yakin Ingin Lanjutkan ?</h4>
            </div>
            {!! Form::open(['method' => 'DELETE', 'id' => 'form_hapus_admin']) !!}
                <div class="modal-footer">
                    @csrf
                    <button type="button" class="btn pull-left" data-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan" value="true" class="btn btn-danger"><i class="fa fa-trash fa-fw"></i> Hapus admin</button>
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
            $('#table_admin').DataTable({
                'lengthChange': false,
                'length': 10,
            })
        })
    </script>

@endsection