@extends('pengguna.master')

@section('title', 'Profile '.$data_pengguna->nama_lengkap)

@section('content')
<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(session()->has('success'))

                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><i class="icon-check"></i> SUCCESS!!</strong> {{ session('success') }}<br>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h2 class="h3 mb-3 text-black">Detail Akun</h2>
            </div>
            <div class="col-md-5">
                <h2 class="h3 mb-3 text-black">Informasi Alamat Pengiriman</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="p-4 border mb-3">
                    <span class="d-block text-primary h6 text-uppercase">Nama Pengguna</span>
                    <p>{{ $data_pengguna->nama_lengkap }}</p>
                    <span class="d-block text-primary h6 text-uppercase">Jenis Kelamin</span>
                    <p>{{ $data_pengguna->jenis_kelamin }}</p>
                    <span class="d-block text-primary h6 text-uppercase">Email</span>
                    <p>{{ $data_pengguna->email }}</p>
                    <span class="d-block text-primary h6 text-uppercase">Tanggal Bergabung</span>
                    <p class="mb-0">{{ $data_pengguna->tanggal_bergabung }}</p>
                </div>
            </div>
            <div class="col-md-5">
                <div class="p-4 border mb-3">
                    <span class="d-block text-primary h6 text-uppercase">Nama Penerima</span>
                    <p>{{ $data_pengguna->nama_lengkap }}</p>
                    <span class="d-block text-primary h6 text-uppercase">Alamat Rumah</span>
                    <p>
                        @if($data_pengguna->alamat_rumah != NULL)
                            {{ $data_pengguna->alamat_rumah }}
                        @else
                            <span class="badge badge-warning">Alamat Belum Tersedia</span>
                        @endif
                    </p>
                    <span class="d-block text-primary h6 text-uppercase">No. Telepon</span>
                    <p>
                        @if($data_pengguna->no_telepon != NULL)
                            {{ $data_pengguna->no_telepon }}
                        @else
                            <span class="badge badge-warning">No.Telepon Belum Tersedia</span>
                        @endif
                    </p>
                    <span class="d-block text-primary h6 text-uppercase">Alamat Tambahan</span>
                    <p class="mb-0">
                        <?php
                            if($data_pengguna->id_kecamatan != NULL) {
                                $get_kecamatan = DB::table('tbl_kecamatan')->where('id', $data_pengguna->id_kecamatan)->first();
                                $get_kabupaten = DB::table('tbl_kabupaten')->where('id', $get_kecamatan->idkab)->first();
                                $get_provinsi = DB::table('tbl_provinsi')->where('id', $get_kabupaten->idprov)->first();

                                $name_kab = $get_kabupaten->tipe === "Kabupaten" ? 'Kabupaten ' . $get_kabupaten->nama : 'Kota ' . $get_kabupaten->nama;
                                $name_prov = 'Prov. ' . $get_provinsi->nama;
                                $name_kec = $get_kecamatan->nama;
                        ?>
                            {{ 'Kec. ' . $name_kec . ', ' . $name_kab . ', ' . $name_prov}}
                        <?php } else { ?>
                            <span class="badge badge-warning">Kecamatan Belum Tersedia</span>
                        <?php } ?>
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <a href="{{ route('edit_info_akun') }}" class="btn btn-info btn-block"><i class="icon-edit"></i> Edit Data Pribadi</a><hr>
                <a href="{{ route('ganti_password') }}" class="btn btn-info btn-block"><i class="icon-lock"></i> Ganti Password</a><hr>
            </div>
        </div>
    </div>
</div>
@endsection
