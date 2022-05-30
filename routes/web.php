<?php

use Illuminate\Http\Request;

/**
 * --------------------------------------------------------------------------
 * ROUTE HALAMAN PENGGUNA
 * --------------------------------------------------------------------------
 *
 */

/** Halaman Beranda Utama */

# METHOD GET
Route::get('/', 'Pengguna\BerandaController@index')->name('beranda');
Route::get('get_kategori', function() {

    $kategori = [];

    foreach(DB::table('tbl_kategori')->select('nama_kategori')->get() as $key => $value) {
        $kategori[] = $value->nama_kategori;
    }

    return response()->json($kategori);

})->name('get_kategori');
Route::get('get_data_counter', function() {

    $pembayaran = DB::table('tbl_pembayaran')->where([
        ['id_pengguna', session('id_pengguna')],
    ]);

    $list = [
        'keranjang' => DB::table('tbl_keranjang')->where('id_pengguna', session('id_pengguna'))->count(),
        'pesanan'   => DB::table('tbl_pesanan')->where([['id_pengguna', '=', session('id_pengguna')], ['status_pesanan', '<=', 4]])->count(),
        'pembayaran'=> !empty($pembayaran->first()->foto_bukti) && $pembayaran->first()->selesai != 1  ? $pembayaran->count() : '0',
    ];

    return response()->json($list);

})->name('data_counter');

# METHOD POST
Route::post('hubungi', 'Pengguna\EmailController@kontak')->name('hubungi_kami');


/** Halaman Autentikasi Pengguna */

# METHOD GET
Route::get('masuk', 'Pengguna\Autentikasi\LoginController@index')->name('login');
Route::get('daftar', 'Pengguna\Autentikasi\RegisterController@index')->name('register');
Route::get('keluar', 'Pengguna\Autentikasi\LoginController@logout')->name('logout');

# METHOD POST
Route::post('masuk', 'Pengguna\Autentikasi\LoginController@login')->name('proses_login');
Route::post('daftar', 'Pengguna\Autentikasi\RegisterController@register')->name('proses_regis');


/** Halaman Lupa Password Pengguna */

# METHOD GET
Route::get('lupa-password', 'Pengguna\Autentikasi\ResetPasswordController@index')->name('lupa_password');
Route::get('lupa-password/reset', 'Pengguna\Autentikasi\ResetPasswordController@reset_page')->name('reset_page');

# METHOD POST
Route::post('lupa-password/send', 'Pengguna\Autentikasi\ResetPasswordController@send_token')->name('send_token');

# METHOD PUT
Route::put('lupa-password/proses', 'Pengguna\Autentikasi\ResetPasswordController@reset_password')->name('proses_password');


/** Halaman Akun Pengguna */

# METHOD GET
Route::get('info_akun', 'Pengguna\Akun\AkunController@index')->name('info_akun');
Route::get('info_akun/edit', 'Pengguna\Akun\InformasiAkunController@index')->name('edit_info_akun');
Route::get('info_akun/ganti_password', 'Pengguna\Akun\GantiPasswordController@index')->name('ganti_password');

# METHOD PUT
Route::put('info_akun/edit', 'Pengguna\Akun\InformasiAkunController@simpan_informasi')->name('simpan_info_akun');
Route::put('info_akun/ganti_password', 'Pengguna\Akun\GantiPasswordController@simpan_password')->name('simpan_password');


/** Halaman Produk*/

# METHOD GET
Route::get('produk', 'Pengguna\Produk\ProdukController@index')->name('produk');
Route::get('produk/detail/{id_barang}', 'Pengguna\Produk\DetailProdukController@index')->name('detail_produk');

# METHOD POST
Route::post('produk/tambah-keranjang/{id_barang}', 'Pengguna\Produk\DetailProdukController@masukan_keranjang')->name('tambah_keranjang');




/** Halaman Keranjang */

# METHOD GET
Route::get('keranjang', 'Pengguna\Keranjang\KeranjangController@index')->name('keranjang');

# METHOD PUT
Route::put('keranjang/update/{id_barang}', 'Pengguna\Keranjang\KeranjangController@update')->name('update_keranjang');

# METHOD DELETE
Route::delete('keranjang/delete/{id_barang}', 'Pengguna\Keranjang\KeranjangController@delete')->name('delete_keranjang');

/** Halaman Checkout */

# METHOD GET
Route::get('checkout', 'Pengguna\Keranjang\CheckoutController@index')->name('checkout');
Route::get('selesai', function(){
    return view('pengguna.keranjang.terimakasih');
});
Route::get('get_provinsi', function() {
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "UTF-8",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "key: 1a84ef0ff7cac9bb764f1087e64da8d3"
        ],
    ]);

    $result = curl_exec($curl);

    return response()->json($result);
});

Route::get('get_kurir', function() {
    foreach(DB::table('tbl_kurir')->get() as $kr){
        $kurir = explode("|", DB::table('tbl_website')->where('id', 19)->value('value'));
        if(in_array($kr->id, $kurir)){
            echo '<option value="'.$kr->rajaongkir.'">'.$kr->nama.'</option>';
        }
    }
});

Route::get('get_kota', function(Request $request) {
    $curl = curl_init();

    $id = $request->input('provinsi');

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=".$id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "UTF-8",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "key: 1a84ef0ff7cac9bb764f1087e64da8d3"
        ],
    ]);

    $result = curl_exec($curl);

    return response()->json($result);
});

# METHOD POST
Route::post('get_cost', function(Request $request) {
    $curl = curl_init();

    $id_city     = $request->input('kota');
    $berat       = $request->input('berat');

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=115&destination=".$id_city."&weight=".$berat."&courier=jne",
        CURLOPT_HTTPHEADER => [
            'content-type: application/x-www-form-urlencoded',
            "key: 1a84ef0ff7cac9bb764f1087e64da8d3"
        ],
    ]);

    $result = curl_exec($curl);

    return response()->json($result);
});

Route::get('get_layanan', function(Request $request) {
    $curl = curl_init();

    $id_city     = DB::table('tbl_kecamatan')->where('id', $request->input('id_kec'))->value('rajaongkir');
    
    $kurir     = $request->input('id_kurir');
    $berat       = $request->input('berat');

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://bukuwarung.com/wp-admin/admin-ajax.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'action' => 'post_cost',
            'origin' => DB::table('tbl_website')->where('id', 18)->value('value'),
            'originType' => 'city',
            'destination' => $id_city,
            'destinationType' => 'subdistrict',
            'weight' => $berat,
            'courier' => $kurir
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    return response()->json($response);
});

Route::post('checkout', 'Pengguna\Keranjang\CheckoutController@save_checkout')->name('save_checkout');


/** Halaman Pesanan*/

# METHOD GET
Route::get('pesanan', 'Pengguna\Pesanan\PesananController@index')->name('pesanan');
Route::get('pesanan/detail_pesanan/{id_pesanan}', 'Pengguna\Pesanan\PesananController@detail_pesanan')->name('detail_pesanan');
Route::get('pesanan/riwayat', 'Pengguna\Pesanan\PesananController@riwayat_pesanan')->name('riwayat_pesanan');

# METHOD put
Route::put('pesanan/dibatalkan/{id_pesanan}', 'Pengguna\Pesanan\PesananController@dibatalkan')->name('pesanan_dibatalkan');
Route::put('pesanan/konfirmasi/{id_pesanan}', 'Pengguna\Pesanan\PesananController@konfirmasi_pesanan')->name('konfirmasi_pesanan');



/** Halaman Pembayaran*/

# METHOD GET
Route::get('pembayaran', 'Pengguna\Pesanan\PembayaranController@index')->name('pembayaran');
Route::get('pembayaran/upload-bukti/{id_pesanan}', 'Pengguna\Pesanan\PembayaranController@upload_bukti')->name('upload_bukti');


# METHOD POST
Route::put('pembayaran/upload-bukti/{id_pesanan}/save', 'Pengguna\Pesanan\PembayaranController@save_bukti')->name('save_bukti');


/** Halaman Invoice*/

Route::get('invoice/{id_invoice}', 'Pengguna\Pesanan\PesananController@invoice')->name('invoice');



/**
 * --------------------------------------------------------------------------
 * ROUTE HALAMAN ADMIN
 * --------------------------------------------------------------------------
 *
 */
Route::group(['prefix' => 'admin'], function(){

    /** Halaman Beranda Utama */

    # METHOD GET
    Route::get('/', 'Admin\BerandaController@index')->name('beranda_admin');
    Route::get('sidebar_counter', function() {

        $table = ['barang', 'kategori', 'merk', 'pengguna', 'admin', 'pesanan', 'pembayaran', 'pengiriman'];

        $data = [];

        foreach($table as $key) {

            if($key == 'pengiriman') {

                $data[] = DB::table('tbl_pesanan')->select('id_pesanan')
                    ->where('status_pesanan', 3)->count();

            } else if ($key == 'pesanan') {

                $data[] = DB::table('tbl_pesanan')->select('id_pesanan')
                    ->whereBetween('status_pesanan', [1, 2])->count();

            } else if($key == 'pembayaran') {

                $data[] = DB::table('tbl_pembayaran')->select('id_pesanan')
                    ->where('selesai', 0)->count();

            } else {

                $data[] = DB::table('tbl_'.$key)->count();

            }
        }

        return response()->json($data);

    }); // AJAX

    /** Halaman Beranda Utama */

    # METHOD GET
    Route::get('profile/{id_admin}', 'Admin\ProfileController@index')->name('profile_admin');

    # METHOD PUT
    Route::put('profile/ganti_password/{id_admin}', 'Admin\ProfileController@ganti_password')->name('ganti_password_admin');



    /** Halaman Autentikasi */

    # METHOD GET
    Route::get('login', 'Admin\Autentikasi\LoginController@index')->name('login_admin');
    Route::get('logout', 'Admin\Autentikasi\LoginController@logout')->name('logout_admin');

    # METHOD POST
    Route::post('login', 'Admin\Autentikasi\LoginController@login')->name('proses_login_admin');



    /** Halaman Produk */

    # METHOD GET
    Route::get('produk', 'Admin\Produk\ProdukController@index')->name('list_produk');
    Route::get('get_produk/{id_barang}', function($id_barang) {

        $data = DB::table('tbl_barang')->where('id_barang', $id_barang)->first();

        return response()->json($data);

    }); // AJAX

    # METHOD POST
    Route::post('produk', 'Admin\Produk\ProdukController@tambah_produk')->name('tambah_produk');

    # METHOD PUT
    Route::put('edit_produk/{id_barang}', 'Admin\Produk\ProdukController@edit_produk');

    # METHOD DELETE
    Route::delete('hapus_produk/{id_barang}', 'Admin\Produk\ProdukController@hapus_produk');


    /** Halaman Pengaturan */
    Route::get('pengaturan', 'Admin\Pengaturan\PengaturanController@index')->name('pengaturan');

    # METHOD PUT
    Route::post('pengaturan', 'Admin\Pengaturan\PengaturanController@edit_pengaturan')->name('edit_pengaturan');

    /** Halaman Kategori */

    Route::post('aktifkan_kurir', function(Request $request) {
        if($request->input('push')){
            $toko = DB::table('tbl_website')->where('id', 19)->value('value');
            $kurir = explode("|",$toko);
            $kurir[] = $request->input('push');
            $push = implode("|",$kurir);
            
            $update = DB::table('tbl_website')->where('id', 19)
            ->update(['value' => $push]);
    
            if($update)
            {
                $result = array("success"=>true,"msg"=>"Berhasil mengupdate kurir");
            } else {
                $result = array("success"=>false,"msg"=>"Terjadi kesalahan mengupdate kurir");
            }
        }else{
            $result = array("success"=>false,"msg"=>"Forbidden!");
        }
    
        return response()->json($result);
    });
    
    Route::post('nonaktifkan_kurir', function(Request $request) {
        if($request->input('push')){
            $toko = DB::table('tbl_website')->where('id', 19)->value('value');
            $kurir = explode("|",$toko);
			for($i=0; $i<count($kurir); $i++){
				if($kurir[$i] == $request->input('push')){
					unset($kurir[$i]);
				}
			}
			array_values($kurir);
			$push = implode("|",$kurir);
            
            $update = DB::table('tbl_website')->where('id', 19)
            ->update(['value' => $push]);
    
            if($update)
            {
                $result = array("success"=>true,"msg"=>"Berhasil mengupdate kurir");
            } else {
                $result = array("success"=>false,"msg"=>"Terjadi kesalahan mengupdate kurir");
            }
        }else{
            $result = array("success"=>false,"msg"=>"Forbidden!");
        }
    
        return response()->json($result);
    });

    // METHOD REKENING

    Route::post('update_payment', function(Request $request) {
        switch($request->input('tipe')) {

            case 1;
                $update = DB::table('tbl_website')->where('id', 20)
                ->update(['value' => $request->input('payment_transfer')]);
        
                if($update)
                {
                    $result = array("success"=>true,"msg"=>"Berhasil mengupdate pembayaran");
                } else {
                    $result = array("success"=>false,"msg"=>"Terjadi kesalahan mengupdate pembayaran");
                }	

                return response()->json($result);
            break;
            case 2;
                $update = DB::table('tbl_website')->where('id', 21)
                ->update(['value' => $request->input('payment_midtrans')]);
        
                if($update)
                {
                    $result = array("success"=>true,"msg"=>"Berhasil mengupdate pembayaran");
                } else {
                    $result = array("success"=>false,"msg"=>"Terjadi kesalahan mengupdate pembayaran");
                }	

                return response()->json($result);
            break;
            		
        }
    });

    Route::delete('hapus_rekening', function(Request $request) {
        $delete = DB::table('tbl_rekening')->where('id', $request->input('id'))->delete();
        return redirect()->route('pengaturan')->with('success', 'Rekening Berhasil Di Hapus');
    })->name('hapus_rekening');

    Route::get('edit_rekening/{id}', 'Admin\Pengaturan\PengaturanController@edit_rekening')->name('edit_rekening');
    # METHOD GET
    Route::get('kategori', 'Admin\Produk\KategoriController@index')->name('kategori_produk');
    Route::get('check_kategori/{nama_kategori}', function($nama_kategori){

        $nama_kategori = str_replace('%20', ' ', $nama_kategori);

        $data = DB::table('tbl_kategori')->where('nama_kategori', $nama_kategori)->exists();

        return response()->json($data);

    }); // AJAX

    # METHOD POST
    Route::post('kategori', 'Admin\Produk\KategoriController@tambah_kategori')->name('tambah_kategori');

    # METHOD PUT
    Route::put('edit_kategori/{id_kategori}', 'Admin\Produk\KategoriController@edit_kategori');

    # METHOD DELETE
    Route::delete('hapus_kategori/{id_kategori}', 'Admin\Produk\KategoriController@hapus_kategori');



    /** Halaman Merk */

    # METHOD GET
    Route::get('merk', 'Admin\Produk\MerkController@index')->name('merk_produk');
    Route::get('check_merk', 'Admin\Produk\MerkController@check_merk'); // AJAX

    # METHOD POST
    Route::post('tambah_merk', 'Admin\Produk\MerkController@tambah_merk')->name('tambah_merk');

    # METHOD PUT
    Route::put('edit_merk/{id_merk}', 'Admin\Produk\MerkController@edit_merk');

    # METHOD DELETE
    Route::delete('hapus_merk/{id_merk}', 'Admin\Produk\MerkController@hapus_merk');

    Route::match(array('GET','POST'), 'edit_user/{s}/{id}', function(Request $request, $s, $id) {
        switch($s)
        {
            case 's':
                if ($request->has('simpan') && session('superadmin') == true) {

                    $validasi = Validator::make($request->all(), [
                        'nama_lengkap'  => 'required|regex:/^[a-zA-Z\s]*$/|max:40',
                        'email'         => 'required|email|max:30',
                        'foto'          => 'nullable|image|mimes:jpg,jpeg,png',
                        'password'          => 'nullable',
                        'superadmin' => 'required',
                        'diblokir' => 'required'
                    ]);
        
                    if ($validasi->fails()) {
        
                        return back()->withErrors($validasi);
        
                    }
        
                    $data = DB::table('tbl_admin')->select('foto')->where('id_admin', $id)->first();
        
                    if($request->hasFile('foto')) {
        
                        Storage::delete('public/avatars/admin/'.$data->foto);
        
                        $extension = $request->file('foto')->getClientOriginalExtension();
        
                        $save_foto = Storage::putFileAs(
                            'public/avatars/admin/',
                            $request->file('foto'), $id.'.'.$extension
                        );
        
                        $foto_admin = basename($save_foto);
        
                    }

                    if(empty($request->input('password')))
                    {
                        $password = DB::table('tbl_admin')->where('id_admin', $id)->value('password');
                    } else {
                        $password = Hash::make($request->input('password'), [
                            'memory' => 1024,
                            'time' => 2,
                            'threads' => 2,
                        ]);
                    }
        
                    DB::table('tbl_admin')->where('id_admin', $id)->update([
                        'nama_lengkap'  => $request->input('nama_lengkap'),
                        'email'         => $request->input('email'),
                        'foto'          => $request->hasFile('foto') ? $foto_admin : $data->foto,
                        'superadmin'         => $request->input('superadmin'),
                        'diblokir'         => $request->input('diblokir'),
                        'password'         => $password,
                    ]);
        
                    return redirect()->route('superadmin_admin')->with('success', 'Berhasil Merubah Informasi Admin');
        
                } else  {
                    $data = DB::table('tbl_admin')->where('id_admin', $id)->first();
                    return view('admin.superadmin.admin.edit', ['detail' => $data]);
                }

            break;

            case 'p';

                if ($request->has('simpan') && session('superadmin') == true) {

                    $validasi = Validator::make($request->all(), [
                        'email'         => 'required|email|max:30',
                        'password'          => 'nullable',
                        'nama_lengkap'          => 'required',
                        'alamat_rumah'          => 'nullable',
                        'no_telepon'          => 'nullable',
                        'jenis_kelamin'          => 'required',
                    ]);
        
                    if ($validasi->fails()) {
        
                        return back()->withErrors($validasi);
        
                    }

                    if(empty($request->input('password')))
                    {
                        $password = DB::table('tbl_pengguna')->where('id_pengguna', $id)->value('password');
                    } else {
                        $password = Hash::make($request->input('password'), [
                            'memory' => 1024,
                            'time' => 2,
                            'threads' => 2,
                        ]);
                    }
        
                    $update_detail = DB::table('tbl_detail_pengguna')->where('id_pengguna', $id)->update([
                        'nama_lengkap'  => $request->input('nama_lengkap'),
                        'jenis_kelamin'         => $request->input('jenis_kelamin'),
                        'alamat_rumah'          => $request->input('alamat_rumah'),
                        'no_telepon'         => $request->input('no_telepon')
                    ]);

                    $update_pengguna = DB::table('tbl_pengguna')->where('id_pengguna', $id)->update([
                        'email'  => $request->input('email'),
                        'password'         => $password
                    ]);
                    
                    return redirect()->route('superadmin_pengguna')->with('success', 'Berhasil Merubah Informasi Pengguna');
                } else  {
                    $data = DB::table('tbl_pengguna')->where('id_pengguna', $id)->first();
                    return view('admin.superadmin.pengguna.edit', ['detail' => [
                        'pengguna' => $data,
                        'info' => DB::table('tbl_detail_pengguna')->where('id_pengguna', $id)->first()
                    ]]);
                }

            break;
        }
    });

    /** Halaman Superadmin : Admin */

    # METHOD GET
    Route::get('superadmin/admin', 'Admin\Superadmin\AdminController@index')->name('superadmin_admin');
    Route::get('superadmin/blokir_admin/{id_admin}', 'Admin\Superadmin\AdminController@blokir_admin')->name('blokir');
    Route::get('superadmin/get_admin/{id_admin}', 'Admin\Superadmin\AdminController@get_admin'); // AJAX

    # METHOD POST
    Route::post('superadmin/tambah_admin', 'Admin\Superadmin\AdminController@tambah_admin')->name('tambah_admin');

    # METHOD PUT
    Route::put('superadmin/edit_admin/}id_admin}', 'Admin\Superadmin\AdminController@edit_admin');
    Route::put('superadmin/ubah_status_admin/{id_admin}', 'Admin\Superadmin\AdminController@ubah_status_admin');

    # METHOD DELETE
    Route::delete('superadmin/hapus_admin/{id_admin}', 'Admin\Superadmin\AdminController@hapus_admin');



    /** Halaman Superadmin : Pengguna */

    # METHOD GET
    Route::get('superadmin/pengguna', 'Admin\Superadmin\PenggunaController@index')->name('superadmin_pengguna');
    Route::get('superadmin/get_pengguna/{id_pengguna}', 'Admin\Superadmin\PenggunaController@get_pengguna'); // AJAX

    # METHOD DELETE
    Route::delete('superadmin/hapus_pengguna/{id_pengguna}', 'Admin\Superadmin\PenggunaController@hapus_pengguna');



    /** Halaman Transaksi : Pembayaran */

    # METHOD GET
    Route::get('transaksi/pembayaran', 'Admin\Transaksi\PembayaranController@index')->name('pembayaran_admin');
    Route::get('transaksi/get_pembayaran/{id_pesanan}', 'Admin\Transaksi\PembayaranController@get_pembayaran'); // AJAX

    # METHOD PUT
    Route::put('transaksi/pembayaran/status/{id_pesanan}', 'Admin\Transaksi\PembayaranController@rubah_status')->name('rubah_status_pembayaran');



    /** Halaman Transaksi : Pesanan */

    # METHOD GET
    Route::get('transaksi/pesanan', 'Admin\Transaksi\PesananController@index')->name('pesanan_admin');
    Route::get('transaksi/pesanan/detail/{id_pesanan}', 'Admin\Transaksi\PesananController@detail_pesanan')->name('detail_pesanan_admin');
    Route::get('transaksi/get_penerima/{id_pesanan}', 'Admin\Transaksi\PesananController@get_info_penerima'); // AJAX

    # METHOD PUT
    Route::put('transaksi/proses_pesanan/{id_pesanan}', 'Admin\Transaksi\PesananController@proses_pesanan');
    Route::put('transaksi/kirim_pesanan/{id_pesanan}', 'Admin\Transaksi\PesananController@kirim_pesanan');
    Route::put('transaksi/batalkan_pesanan/{id_pesanan}', 'Admin\Transaksi\PesananController@batalkan_pesanan');
    Route::put('transaksi/edit_pesanan/{id_pesanan}', 'Admin\Transaksi\PesananController@edit_pesanan');

    # METHOD DELETE
    Route::delete('transaksi/hapus_pesanan/{id_pesanan}', 'Admin\Transaksi\PesananController@hapus_pesanan');



    /** Halaman Transaksi : Pengiriman */

    # METHOD GET
    Route::get('transaksi/pengiriman', 'Admin\Transaksi\PengirimanController@index')->name('pengiriman_admin');

    # METHOD PUT
    Route::put('transaksi/selesai/{id_pesanan}', 'Admin\Transaksi\PengirimanController@selesai');
    Route::put('transaksi/dibatalkan/{id_pesanan}', 'Admin\Transaksi\PengirimanController@batalkan_pesanan');


    /** Halaman Laporan : Transaksi */

    # METHOD GET
    Route::get('laporan/transaksi', 'Admin\Laporan\TransaksiController@index')->name('laporan_transaksi');

    # METHOD POST
    Route::post('laporan/transaksi/print', 'Admin\Laporan\TransaksiController@print_transaksi')->name('print_transaksi');

});

/**
 * --------------------------------------------------------------------------
 * Testing Unit Route
 * --------------------------------------------------------------------------
 *
 */

 # METHOD GET
Route::get('test', 'Test\TestingController@index')->name('test');
Route::get('page', 'Test\TestingController@page')->name('page_test');
// Route::get('test', function(Request $request) {
//     return view('test');
// });


# METHOD POST
Route::post('test', 'Test\TestingController@test')->name('test_form');
Route::get('send', 'Pengguna\EmailController@lupa_password');
