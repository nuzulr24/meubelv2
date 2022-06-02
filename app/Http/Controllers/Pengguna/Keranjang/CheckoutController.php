<?php

namespace App\Http\Controllers\Pengguna\Keranjang;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {

        if (session()->has('email_pengguna')) {

            $data = DB::table('tbl_keranjang as keranjang')
                ->join('tbl_barang as barang', 'barang.id_barang', 'keranjang.id_barang')
                ->where('keranjang.id_pengguna', session('id_pengguna'));

            $data_user = DB::table('tbl_pengguna as pengguna')
                ->join('tbl_detail_pengguna as detail_pengguna', 'detail_pengguna.id_pengguna', 'pengguna.id_pengguna')
                ->where('pengguna.id_pengguna', session('id_pengguna'));

            if ($data->exists()) {

                return view('pengguna.keranjang.checkout', [
                    'data_checkout' => $data->get(),
                    'personal' => $data_user->get()->first(),
                ]);

            }

        }

    }

    public function save_checkout(Request $request)
    {

        if (session()->has('email_pengguna') && $request->input('simpan')) {

            $id_pengguna = session('id_pengguna');

            // echo json_encode($request->input(), JSON_PRETTY_PRINT);

            $act = $request->input('alamat');
            switch ($act) {
                case 1;
                    $id_pesanan  = $this->set_id_pesanan();
                    $keranjang = DB::table('tbl_keranjang')->where('id_pengguna', $id_pengguna);
                    $get_kecamatan = DB::table('tbl_kecamatan')->where('id', $request->input('id_kec'))->first();
                    $get_kabupaten = DB::table('tbl_kabupaten')->where('id', $get_kecamatan->idkab)->first();
                    $get_provinsi = DB::table('tbl_provinsi')->where('id', $get_kabupaten->idprov)->first();
                    $detail_user = DB::table('tbl_detail_pengguna')->where('id_pengguna', $id_pengguna)->first();

                    $name_kab = $get_kabupaten->tipe === "Kabupaten" ? 'Kabupaten ' . $get_kabupaten->nama : 'Kota ' . $get_kabupaten->nama;
                    $name_prov = 'Prov. ' . $get_provinsi->nama;
                    $name_kec = $get_kecamatan->nama;

                    $add_address = 'Kec. ' . $name_kec . ', ' . $name_kab . ', ' . $name_prov;

                    $keranjang = DB::table('tbl_keranjang')->where('id_pengguna', $id_pengguna);
                    $get_rekening = DB::table('tbl_rekening')->where('is_active', 1)->first();

                    if($request->input('layanan'))
                    {
                        $extract = explode(',', $request->input('layanan'));
                        $layanan = $extract[1];
                    }

                    if($keranjang->exists()){

                        $save_pesanan = DB::table('tbl_pesanan')->insert([
                            'id_pesanan' => $id_pesanan,
                            'id_pengguna' => $id_pengguna,
                            'nama_penerima' => $detail_user->nama_lengkap,
                            'alamat_tujuan' => $detail_user->alamat_rumah . ', ' . $add_address,
                            'no_telepon' => $detail_user->no_telepon,
                            'keterangan' => !is_null($request->input('keterangan')) ? $request->input('keterangan') : null,
                            'kurir' => $request->input('kurir'),
                            'layanan' => !is_null($request->input('layanan')) ? $layanan : null,
                            'ongkos_kirim' => $request->input('ongkir'),
                            'total_bayar'   => $keranjang->sum('subtotal_biaya'),
                        ]);

                        if($request->input('metode_pembayaran') == 1) {
                            DB::table('tbl_pembayaran')->insert([
                                'id_pesanan' => $id_pesanan,
                                'id_pengguna' => $id_pengguna,
                                'id_bank_receiver' => $get_rekening->id,
                                'id_methode' => 1,
                                'status_pembayaran' => 0,
                                'batas_pembayaran' => Carbon::tomorrow()
                            ]);
                        } else {
                            DB::table('tbl_pembayaran')->insert([
                                'id_pesanan' => $id_pesanan,
                                'id_pengguna' => $id_pengguna,
                                'id_methode' => 2,
                                'status_pembayaran' => 0,
                                'batas_pembayaran' => Carbon::tomorrow()
                            ]);
                        }

                        if($save_pesanan == true) {

                            foreach ($keranjang->get() as $item) {

                                $barang = DB::table('tbl_barang')->where('id_barang', $item->id_barang)->first();

                                $save_detail = DB::table('tbl_detail_pesanan')->insert([
                                    'id_pesanan'     => $id_pesanan,
                                    'id_barang'      => $item->id_barang,
                                    'jumlah_beli'    => $item->jumlah_beli,
                                    'subtotal_berat' => ($item->jumlah_beli * $barang->berat_barang),
                                    'subtotal_biaya' => $item->subtotal_biaya
                                ]);
                            }

                            DB::table('tbl_keranjang')->where('id_pengguna', $id_pengguna)->delete();

                            return redirect()->route('pesanan')->with('success', 'Pesanan Berhasil Di Simpan');

                        } else {

                            // echo 'error';

                            DB::table('tbl_pesanan')->where('id_pesanan', $id_pesanan)->delete();

                            return back()->withErrors('Terjadi Kesalahan Saat Memproses Checkout');

                        }

                    } else {

                        return back()->withErrors('Data Keranjang Tidak Ditemukan');

                    }

                break;

                case 2;
                    $id_pesanan  = $this->set_id_pesanan();
                    $keranjang = DB::table('tbl_keranjang')->where('id_pengguna', $id_pengguna);
                    $get_kecamatan = DB::table('tbl_kecamatan')->where('id', $request->input('id_kec'))->first();
                    $get_kabupaten = DB::table('tbl_kabupaten')->where('id', $get_kecamatan->idkab)->first();
                    $get_provinsi = DB::table('tbl_provinsi')->where('id', $get_kabupaten->idprov)->first();
                    $detail_user = DB::table('tbl_detail_pengguna')->where('id_pengguna', $id_pengguna)->first();

                    $name_kab = $get_kabupaten->tipe === "Kabupaten" ? 'Kabupaten ' . $get_kabupaten->nama : 'Kota ' . $get_kabupaten->nama;
                    $name_prov = 'Prov. ' . $get_provinsi->nama;
                    $name_kec = $get_kecamatan->nama;

                    $add_address = 'Kec. ' . $name_kec . ', ' . $name_kab . ', ' . $name_prov;

                    $keranjang = DB::table('tbl_keranjang')->where('id_pengguna', $id_pengguna);
                    $get_rekening = DB::table('tbl_rekening')->where('is_active', 1)->first();

                    if($request->input('layanan'))
                    {
                        $extract = explode(',', $request->input('layanan'));
                        $layanan = $extract[1];
                    }

                    if($keranjang->exists()){

                        $save_pesanan = DB::table('tbl_pesanan')->insert([
                            'id_pesanan' => $id_pesanan,
                            'id_pengguna' => $id_pengguna,
                            'nama_penerima' => $detail_user->nama_lengkap,
                            'alamat_tujuan' => $detail_user->alamat_rumah . ', ' . $add_address,
                            'no_telepon' => $detail_user->no_telepon,
                            'keterangan' => !is_null($request->input('keterangan')) ? $request->input('keterangan') : null,
                            'kurir' => $request->input('kurir'),
                            'layanan' => !is_null($request->input('layanan')) ? $layanan : null,
                            'ongkos_kirim' => $request->input('ongkir'),
                            'total_bayar'   => $keranjang->sum('subtotal_biaya'),
                        ]);

                        if($request->input('metode_pembayaran') == 1) {
                            DB::table('tbl_pembayaran')->insert([
                                'id_pesanan' => $id_pesanan,
                                'id_pengguna' => $id_pengguna,
                                'id_bank_receiver' => $get_rekening->id,
                                'id_methode' => 1,
                                'status_pembayaran' => 0,
                                'batas_pembayaran' => Carbon::tomorrow()
                            ]);
                        } else {
                            DB::table('tbl_pembayaran')->insert([
                                'id_pesanan' => $id_pesanan,
                                'id_pengguna' => $id_pengguna,
                                'id_methode' => 2,
                                'status_pembayaran' => 0,
                                'batas_pembayaran' => Carbon::tomorrow()
                            ]);
                        }

                        if($save_pesanan == true) {

                            foreach ($keranjang->get() as $item) {

                                $barang = DB::table('tbl_barang')->where('id_barang', $item->id_barang)->first();

                                $save_detail = DB::table('tbl_detail_pesanan')->insert([
                                    'id_pesanan'     => $id_pesanan,
                                    'id_barang'      => $item->id_barang,
                                    'jumlah_beli'    => $item->jumlah_beli,
                                    'subtotal_berat' => ($item->jumlah_beli * $barang->berat_barang),
                                    'subtotal_biaya' => $item->subtotal_biaya
                                ]);
                            }

                            DB::table('tbl_keranjang')->where('id_pengguna', $id_pengguna)->delete();

                            return redirect()->route('pesanan')->with('success', 'Pesanan Berhasil Di Simpan');

                        } else {

                            // echo 'error';

                            DB::table('tbl_pesanan')->where('id_pesanan', $id_pesanan)->delete();

                            return back()->withErrors('Terjadi Kesalahan Saat Memproses Checkout');

                        }

                    } else {

                        return back()->withErrors('Data Keranjang Tidak Ditemukan');

                    }

                break;

            }

        } else {

            return back()->withErrors('Terjadi Kesalahan Saat Menyimpan');

        }

    }

    protected function set_id_pesanan()
    {

        $data = DB::table('tbl_pesanan')->max('id_pesanan');

        if (!empty($data)) {

            $no_urut = substr($data, 9, 3) + 1;

            return 'PSN' . (new Datetime)->format('ymd') . $no_urut;
        } else {
            return 'PSN' . (new Datetime)->format('ymd') . '1';
        }
    }
}
