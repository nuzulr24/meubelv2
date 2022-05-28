@extends('admin.master')

@section('title', 'Edit Pengguna')

@section('extra_css')

{{ Html::style('admin_assets/component/datatables.net-bs/css/dataTables.bootstrap.min.css') }}

@endsection

@section('content-header')
<h1>
    Edit Pengguna
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('beranda_admin') }}"><i class="fa fa-home"></i> Beranda</a></li>
    <li><i class="fa fa-cubes fa-fw"></i> Pengguna</li>
    <li class="active"><i class="fa fa-tags fa-fw"></i> Edit Pengguna</li>
</ol>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
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
    <div class="col-md-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">
                    Edit ({{ $detail->email }})
                </h3>
            </div>
            <div class="box-body">
                {!! Form::open(['method' => 'POST', 'files' => true]) !!}
                @csrf
                <div class="form-group has-feedback">
                    {!! Form::label('exampleEmail1', 'Nama Lengkap') !!}
                    {!! Form::text('nama_lengkap', $detail->nama_lengkap, ['id' => 'nama_lengkap', 'class' =>
                    'form-control']) !!}
                    <span class="help-block"><small>Masukan nama lengkap</small></span>
                </div>
                <div class="form-group has-feedback">
                    {!! Form::label('exampleEmail1', 'Alamat Email') !!}
                    {!! Form::text('email', $detail->email, ['id' => 'email', 'class' => 'form-control']) !!}
                    <span class="help-block"><small>Masukan alamat email</small></span>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            {!! Form::label('exampleEmail1', 'Kata Sandi') !!}
                            {!! Form::text('password', null, ['id' => 'password', 'class' => 'form-control']) !!}
                            <span class="help-block"><small>Silahkan kosongi jika tidak ingin merubah kata sandi</small></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            {!! Form::label('exampleEmail1', 'Foto') !!}
                            {!! Form::file('foto', ['id' => 'foto', 'class' => 'form-control' , 'style' => 'border: none;', 'accept' => '.jpg, .jpeg, .png']) !!}
                            <span class="help-block"><small>Kosongi jika tidak ingin merubah foto</small></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            {!! Form::label('exampleEmail1', 'Super Admin') !!}
                            <select class="form-control" name="superadmin">
                                <option value="">Pilih level</option>
                                <?php $list = [0,1]; foreach($list as $item) { 
                                    $select = $item == $detail->superadmin ? 'selected' : '';    
                                    $selected = $item == $detail->superadmin ? '(selected)' : ''; 
                                    $names = $item == 1 ? 'Super Admin' : 'Admin';
                                ?>
                                    <option value="{{ $item }}" {{ $select }}>{{ $names }} {{ $selected }}</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            {!! Form::label('exampleEmail1', 'Status Akun') !!}
                            <select class="form-control" name="diblokir">
                                <option value="">Pilih Status</option>
                                <?php $list = [0,1]; foreach($list as $item) { 
                                    $select = $item == $detail->diblokir ? 'selected' : '';    
                                    $selected = $item == $detail->diblokir ? '(selected)' : ''; 
                                    $names = $item == 1 ? 'Ya' : 'Tidak';
                                ?>
                                    <option value="{{ $item }}" {{ $select }}>{{ $names }} {{ $selected }}</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <button type="submit" name="simpan" value="true" class="btn btn-primary btn-flat">Edit</button>
                    <button class="btn btn-danger btn-flat">Kembali</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
</div>

@endsection

@section('extra_js')

{{ Html::script('admin_assets/component/datatables.net/js/jquery.dataTables.min.js') }}
{{ Html::script('admin_assets/component/datatables.net-bs/js/dataTables.bootstrap.min.js') }}

<script>
    $(document).ready(function () {
        $('#table_merk').DataTable({
            'lengthChange': false,
            'length': 10,
            'searching': false
        })
    })

</script>

@endsection
