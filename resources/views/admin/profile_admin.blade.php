@extends('admin.master')

@section('title', 'Profile Admin')

@section('extra_css')

    <style>
        .profile-user-img {
            width: 120px;
        }
    </style>

@endsection

@section('content-header')
<h1>
    Profile @if($data_admin->superadmin == true) SuperAdmin @else Admin @endif
    <small>Halaman profile</small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('beranda_admin') }}"><i class="fa fa-home"></i> Beranda</a></li>
    <li><i class="fa fa-user fa-fw"></i> Profile</li>
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
    </div>
    <div class="col-md-3 col-sm-12">

        <!-- Profile Image -->
        <div class="box box-primary solid">
            <div class="box-body box-profile">
                <?php
                    if (Storage::exists(public_path('storage/avatars/admin/' . session('foto_admin')))) {
                ?>
                    <img src="<?= public_path('storage/avatars/admin/' . session('foto_admin')) ?>" class="profile-user-img img-responsive img-circle" alt="<?= session('nama_admin') ?>">
                <?php } else { ?>
                    <img src="https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?f=y" class="profile-user-img img-responsive img-circle" alt="Empty">
                <?php } ?>

                <h3 class="profile-username text-center">{{ $data_admin->nama_lengkap }}</h3>

                <p class="text-muted text-center">
                    @if($data_admin->superadmin == true)
                        Super Admin
                    @else
                        Admin
                    @endif
                </p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Level</b>
                        @if ($data_admin->superadmin == true)
                            <span class="label bg-green pull-right"><i class="fa fa-check"></i> Superadmin</span>
                        @else
                            <span class="label bg-red pull-right"><i class="fa fa-close"></i> Admin</span>
                        @endif
                    </li>
                    @if ($data_admin->superadmin == true)
                    <li class="list-group-item">
                        <b>Di Blokir</b>
                        @if ($data_admin->diblokir == true)
                            <span class="label bg-red pull-right"><i class="fa fa-ban"></i> Di Blokir</span>
                        @else
                            <span class="label bg-green pull-right"><i class="fa fa-check"></i> Tidak Di Blokir</span>
                        @endif
                    </li>
                    @endif
                    <li class="list-group-item">
                        <b>Bergabung</b> <a class="pull-right">{{ $data_admin->tanggal_bergabung }}</a>
                    </li>
                </ul>

                <a href="{{ route('beranda_admin') }}" class="btn btn-warning btn-block"><b><i class="fa fa-arrow-left fa-fw"></i> Kembali Ke Beranda</b></a>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Informasi Detail</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-sm btn-warning btn-flat" data-toggle="modal" data-target="#ganti_password">
                        <i class="fa fa-key fa-fw"></i> Ganti Password
                    </button>
                </div>
            </div>
            <div class="box-body row">
                <div class="col-md-6">
                    <h3 class="profile-username">ID Admin</h3>
                    <h4 class="text-muted">{{ $data_admin->id_admin }}</h4>
                    <h3 class="profile-username">Nama lengkap</h3>
                    <h4 class="text-muted">{{ $data_admin->nama_lengkap }}</h4>
                </div>
                <div class="col-md-6">
                    <h3 class="profile-username">Email Admin</h3>
                    <h4 class="text-muted">{{ $data_admin->email }}</h4>
                    <h3 class="profile-username">Tanggal Bergabung</h3>
                    <h4 class="text-muted">{{ $data_admin->tanggal_bergabung }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal modal-default fade" id="ganti_password">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Ganti Password Akun</h4>
                </div>
                <div class="modal-body">
                {!! Form::open(['route' => ['ganti_password_admin', session('id_admin')], 'method' => 'PUT']) !!}
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_password_lama', 'Password Lama') !!}
                        {!! Form::password('password_lama', ['id' => 'inp_password_lama', 'class' => 'form-control']) !!}
                        <span class="help-block"><small>Silahkan masukan password admin tanpa karakter khusus</small></span>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_password_baru', 'Password Baru') !!}
                        {!! Form::password('password_baru', ['id' => 'inp_password_baru', 'class' => 'form-control']) !!}
                        <span class="help-block"><small>Silahkan masukan password admin tanpa karakter khusus</small></span>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('inp_password_konfirmasi', 'Ulangi Password') !!}
                        {!! Form::password('password_baru_confirmation', ['id' => 'inp_password_konfirmasi', 'class' => 'form-control']) !!}
                        <span class="help-block"><small>Silahkan masukan password admin tanpa karakter khusus</small></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="simpan" value="true" class="btn btn-primary btn-flat">Simpan</button>
                        <button type="reset" class="btn btn-danger btn-flat pull-right">Reset</button>
                    </div>
                {!! Form::close() !!}
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection
