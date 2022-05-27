@extends('pengguna.master')

@section('title', 'Lupa Password')

@section('breadcrumb')
<div class="bg-light py-3" data-aos="fade" data-aos-delay="100">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0">
                <a href="{{ route('beranda') }}">Beranda</a>
                <span class="mx-2 mb-0">/</span>
                <strong class="text-black">Lupa Password</strong>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="site-section">
    <div class="container">
        <div class="row" data-aos="fade" data-aos-delay="100">
            <div class="col-md-12">
                <h2 class="h3 mb-3 text-black text-center">Buat Password</h2>
            </div>
            <div class="col-md-5 mx-auto">
                {{ Form::open(['route' => 'proses_password', 'method' => 'PUT']) }}
                    <div class="p-3 p-lg-5 border">
                        @if ($errors->any())

                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong><i class="fa fa-ban fa-fw"></i> ERROR!!</strong><br>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                        @endif
                        <input type="hidden" name="user_token" value="{{ $_GET['_token'] }}">
                        <input type="hidden" name="_user" value="{{ $_GET['_user'] }}">
                        <div class="form-group">
                            {{ Form::label('inp_password', 'Password Baru', ['class' => 'text-black']) }}
                            {{ Form::password('password', ['class' => 'form-control', 'id' => 'inp_password']) }}
                            <small class="help-block">Passtikan buat password yang sulit contoh : <code><?=str_random(16)?></code></small>
                        </div>
                        <div class="form-group">
                            {{ Form::label('inp_password_confirmation', 'Ulangi Password', ['class' => 'text-black']) }}
                            {{ Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'inp_password_confirmation']) }}
                        </div>
                        <div class="form-group row mt-5">
                            <div class="col-lg-12">
                                <button type="submit" name="simpan" value="true" class="btn btn-primary btn-lg btn-block">Reset Password</button>
                            </div>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
