@extends('pengguna.master')

@section('title', 'Upload Bukti')

@section('breadcrumb')
<div class="bg-light py-3" data-aos="fade-up" data-aos-delay="100">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0">
                <a href="{{ route('beranda') }}">Beranda</a>
                <span class="mx-2 mb-0">/</span>
                <a href="{{ route('pembayaran') }}">Pembayaran</a>
                <span class="mx-2 mb-0">/</span>
                <strong class="text-black">Upload Bukti</strong>
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
                <h2 class="h3 mb-3 text-black text-center">Upload Bukti Pembayaran</h2>
            </div>
            <div class="col-md-5 mx-auto">
                {{ Form::open(['route' => ['save_bukti', $id_pesanan], 'files' => true, 'method' => 'PUT']) }}
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

                    @endif
                    <div class="form-group">
                        {{ Form::label('inp_bukti_pembayaran', 'Bukti Pembayaran', ['class' => 'text-black']) }}
                        {{ Form::file('bukti_pembayaran', ['class' => 'form-control', 'id' => 'inp_bukti_pembayaran', 'style' => 'border: 0;']) }}
                        <small class="help-block">Pastikan format foto yang di upload : jpg, jpeg, atau png</small>
                    </div>
                    <div class="form-group">
                        {{ Form::label('exampleEmail1', 'Atas Nama', ['class' => 'text-black']) }}
                        {{ Form::text('atas_nama', null, ['class' => 'form-control', 'id' => 'atas_nama']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('exampleEmail1', 'Nomer Rekening', ['class' => 'text-black']) }}
                        {{ Form::number('no_rekening', null, ['class' => 'form-control', 'id' => 'no_rekening']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('exampleEmail1', 'Dari Bank', ['class' => 'text-black']) }}
                        <select class="form-control" name="bank">
                            <option value="">-- pilih salah satu --</option>
                            <?php foreach(DB::table('tbl_rekeningbank')->get() as $items) { ?>
                            <option value="<?= $items->nama ?>"><?= $items->nama ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group row mt-5">
                        <div class="col-lg-12">
                            <button type="submit" name="simpan" value="true"
                                class="btn btn-primary btn-lg btn-block">Upload Bukti</button>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
