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
                    Edit ({{ $detail['pengguna']->email }})
                </h3>
            </div>
            <div class="box-body">
                {!! Form::open(['method' => 'POST', 'files' => true]) !!}
                @csrf
                <div class="form-group has-feedback">
                    {!! Form::label('exampleEmail1', 'Nama Lengkap') !!}
                    {!! Form::text('nama_lengkap', $detail['info']->nama_lengkap, ['id' => 'nama_lengkap', 'class' =>
                    'form-control']) !!}
                    <span class="help-block"><small>Masukan nama lengkap</small></span>
                </div>
                <div class="form-group has-feedback">
                    {!! Form::label('exampleEmail1', 'Alamat Email') !!}
                    {!! Form::email('email', $detail['pengguna']->email, ['id' => 'email', 'class' => 'form-control']) !!}
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
                            {!! Form::label('exampleEmail1', 'Jenis Kelamin') !!}
                            <select class="form-control" name="jenis_kelamin">
                                <option value="">Pilih Jenis Kelamin</option>
                                <?php $list = ['Pria', 'Wanita']; foreach($list as $item) { 
                                    $select = $item == $detail['info']->jenis_kelamin ? 'selected' : '';    
                                    $selected = $item == $detail['info']->jenis_kelamin ? '(selected)' : ''; 
                                ?>
                                    <option value="{{ $item }}" {{ $select }}>{{ $item }} {{ $selected }}</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            {!! Form::label('exampleEmail1', 'Alamat Rumah') !!}
                            {!! Form::text('alamat_rumah', $detail['info']->alamat_rumah, ['id' => 'alamat_rumah', 'class' => 'form-control']) !!}
                            <span class="help-block"><small>lengkapi alamat rumah untuk lebih detil</small></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            {!! Form::label('exampleEmail1', 'Nomer Telepon') !!}
                            {!! Form::number('no_telepon', $detail['info']->no_telepon, ['id' => 'no_telepon', 'class' => 'form-control']) !!}
                            <span class="help-block"><small>Masukkan data nomer telepon</small></span>
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
