@extends('pengguna.master')

@section('title', 'Masuk')

@section('breadcrumb')
<div class="bg-light py-3" data-aos="fade-up" data-aos-delay="100">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0">
                <a href="{{ route('beranda') }}">Beranda</a>
                <span class="mx-2 mb-0">/</span>
                <strong class="text-black">Masuk</strong>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="site-section">
    <div class="container">
        <div class="row" data-aos="fade-up" data-aos-delay="100">
            <div class="col-md-12">
                <h2 class="h3 mb-3 text-black text-center">Masuk</h2>
            </div>
            <div class="col-md-5 mx-auto">
                {{ Form::open(['route' => 'login']) }}
                    <div class="p-3 p-lg-5 border">
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

                        @elseif(session()->has('success'))

                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong><i class="icon-check"></i> SUCCESS!!</strong> {{ session('success') }}<br>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                        @endif
                        <div class="form-group">
                            {{ Form::label('inp_email', 'Email', ['class' => 'text-black']) }}
                            {{ Form::email('email', null, ['class' => 'form-control', 'id' => 'inp_email']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('inp_password', 'Password', ['class' => 'text-black']) }}
                            {{ Form::password('password', ['class' => 'form-control', 'id' => 'inp_password']) }}
                        </div>
                        <div class="form-group row mt-5">
                            <div class="col-lg-12">
                                <button type="submit" name="simpan" value="true" class="btn btn-primary btn-lg btn-block">Masuk</button>
                            </div>
                            <div class="col-lg-12 mt-2">
                                <p class="my-0 mx-0">Lupa Password ? <a href="{{ route('lupa_password') }}">Klik Di Sini</a></p>
                            </div>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
