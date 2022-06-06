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
            <div class="col-md-12">
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
                            {{ Form::number('no_telepon',$data_informasi->no_telepon, ['class' => 'form-control', 'id' => 'inp_no_telepon']) }}
                        </div>
                        <div class="form-group">
                            {{ Form::label('inp_alamat', 'Alamat Rumah', ['class' => 'text-black']) }}
                            {{ Form::textarea('alamat_rumah',$data_informasi->alamat_rumah, [
                                        'class' => 'form-control', 'id' => 'inp_alamat', 'rows' => '5'
                                    ]) }}
                        </div>
                    </div>

                    <?php
                        $data_kec = DB::table('tbl_detail_pengguna')->where('id_pengguna', session('id_pengguna'))->first();
                        if(!empty($data_kec->id_kecamatan)) {
                            $get_kecamatan = DB::table('tbl_kecamatan')->where('id', $data_kec->id_kecamatan)->first();
                            $get_kabupaten = DB::table('tbl_kabupaten')->where('id', $get_kecamatan->idkab)->first();
                            $get_provinsi = DB::table('tbl_provinsi')->where('id', $get_kabupaten->idprov)->first();

                            $name_kab = $get_kabupaten->tipe === "Kabupaten" ? 'Kabupaten ' . $get_kabupaten->nama : 'Kota ' . $get_kabupaten->nama;
                    ?>
                        <div class="col-md-4">
                            <label for="inp_provinsi" class="text-black">Provinsi</label>
                            <select class="form-control" name="provinsi" id="provinsi">
                                <?php
                                    foreach(DB::table('tbl_provinsi')->get() as $prov) {
                                        $select = $prov->id == $get_kabupaten->idprov ? 'selected' : '';
                                ?>
                                    <option value="<?= $prov->id ?>" <?= $select ?>><?= $prov->nama ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="inp_kota" class="text-black">Kota</label>
                            <select class="form-control" name="kabupaten" id="kabupaten">
                                <?php
                                    foreach(DB::table('tbl_kabupaten')->where('idprov', $get_kabupaten->idprov)->get() as $kab) {
                                        $select = $get_kecamatan->idkab == $kab->id ? 'selected' : '';
                                ?>
                                    <option value="<?= $kab->id ?>" <?= $select ?>><?= $kab->nama ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="inp_provinsi" class="text-black">Kecamatan</label>
                            <select class="form-control" name="kecamatan" id="kecamatan">
                                <?php
                                    foreach(DB::table('tbl_kecamatan')->where('idkab', $get_kabupaten->id)->get() as $kec) {
                                        $select = $get_kecamatan->id == $kec->id ? 'selected' : '';
                                ?>
                                    <option value="<?= $kec->id ?>" <?= $select ?>><?= $kec->nama ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } else { ?>
                        <div class="col-md-4">
                            <label for="inp_provinsi" class="text-black">Provinsi</label>
                            <select class="form-control" name="provinsi" id="provinsi">
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="inp_kota" class="text-black">Kota</label>
                            <select class="form-control" name="kabupaten" id="kabupaten"></select>
                        </div>
                        <div class="col-md-4">
                            <label for="inp_provinsi" class="text-black">Kecamatan</label>
                            <select class="form-control" name="kecamatan" id="kecamatan"></select>
                        </div>
                    <?php } ?>
                    <div class="form-group row mt-3">
                        <div class="col-md-12">
                            <button type="submit" name="simpan" value="true" class="btn btn-primary btn-lg">Simpan
                                Perubahan</button>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom_js')
<script>
    $(document).ready(function() {
        var url = 'http://'+window.location.host
        
        $.get(url+'/get_prov').done(function(result){
        $('select#provinsi').html(result)

        $('#provinsi').change(function() {
            let id_prov = this.value;
            $.get(url+'/get_city?provinsi', {'provinsi': id_prov}).done(function(result){
                $('select#kabupaten').html(result)

                $('#kabupaten').change(function() {
                    let id_kab = this.value;
                    $.get(url+'/get_kec?kecamatan', {'kecamatan': id_kab}).done(function(result){
                        $('select#kecamatan').html(result)

                        $('#kecamatan').change(function() {
                            let id_kec = this.value;
                            $('#id_kec').val(id_kec);
                        })
                    })
                })
            })
        })
    })
    })
</script>
@endsection
