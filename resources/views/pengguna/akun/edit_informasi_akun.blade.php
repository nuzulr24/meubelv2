@extends('pengguna.master')

@section('title', 'Rubah Data Pribadi')

@section('breadcrumb')
<div class="bg-light py-3" data-aos="fade" data-aos-delay="100">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0">
                <a href="{{ route('beranda') }}">Beranda</a>
                <span class="mx-2 mb-0">/</span>
                <a href="{{ route('info_akun') }}">Profile</a>
                <span class="mx-2 mb-0">/</span>
                <strong class="text-black">Edit Data Pribadi</strong>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="site-section">
    <div class="container">
        <div class="row" data-aos="fade" data-aos-delay="100">
            <div class="col md-12 mb-5">
                <a href="{{ route('info_akun') }}" class="btn btn-warning">Kembali</a>
            </div>
            <div class="col-md-12">
                <h2 class="h3 mb-3 text-black">Edit Data Pribadi</h2>
            </div>
            <div class="col-md-8">
                @if ($errors->any())

                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="icon-ban"></i> ERROR!!</strong><br>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                @endif
                {{ Form::open(['route' => 'simpan_info_akun', 'method' => 'PUT']) }}
                    <div class="p-3 p-lg-5 border row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ Form::label('inp_nama', 'Nama Lengkap', ['class' => 'text-black']) }}
                                {{ Form::text('nama_lengkap',$data_informasi->nama_lengkap, ['class' => 'form-control', 'id' => 'inp_nama']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('inp_jenis_kelamin', 'Jenis Kelamin', ['class' => 'text-black']) }}
                                {{ Form::select('jenis_kelamin', ['Pria' => 'Pria', 'Wanita' => 'Wanita'],$data_informasi->jenis_kelamin, [
                                    'placeholder' => 'Pilih Jenis Kelamin..', 'class' => 'form-control', 'id' => 'inp_jenis_kelamin']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('inp_email', 'Email', ['class' => 'text-black']) }}
                                {{ Form::email('email',$data_informasi->email, ['class' => 'form-control', 'id' => 'inp_email']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('inp_no_telepon', 'No. Telepon', ['class' => 'text-black']) }}
                                {{ Form::text('no_telepon',$data_informasi->no_telepon, ['class' => 'form-control', 'id' => 'inp_no_telepon']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('inp_alamat', 'Alamat Rumah', ['class' => 'text-black']) }}
                                {{ Form::textarea('alamat_rumah',$data_informasi->alamat_rumah, [
                                        'class' => 'form-control', 'id' => 'inp_alamat', 'rows' => '5'
                                    ]) }}
                            </div>
                        </div>
                        <div class="col-md-12 mt-5">
                            <h5>Konfirmasi Password</h5>
                            <hr>
                            <div class="form-group">
                                {{ Form::label('inp_password', 'Password', ['class' => 'text-black']) }}
                                {{ Form::password('password', ['class' => 'form-control', 'id' => 'inp_password']) }}
                            </div>
                            <div class="form-group row mt-5">
                                <div class="col-lg-12">
                                    <button type="submit" name="simpan" value="true" class="btn btn-primary btn-lg btn-block">Simpan Perubahan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
