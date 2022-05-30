<?php

namespace App\Http\Controllers\Pengguna\Keranjang;

use DateTime;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class CheckoutController extends Controller
{
    public function index(Request $request) {

        if (session()->has('email_pengguna')) {

            $data = DB::table('tbl_keranjang as keranjang')
                ->join('tbl_barang as barang', 'barang.id_barang', 'keranjang.id_barang')
                ->where('keranjang.id_pengguna', session('id_pengguna'));

            $data_user = DB::table('tbl_pengguna as pengguna')
                ->join('tbl_detail_pengguna as detail_pengguna', 'detail_pengguna.id_pengguna', 'pengguna.id_pengguna')
                ->where('pengguna.id_pengguna', session('id_pengguna'));

            if($data->exists()) {

                return view('pengguna.keranjang.checkout', [
                    'data_checkout' => $data->get(),
                    'personal' => $data_user->get()->first()
                ]);

            }

        }

    }

    public function save_checkout(Request $request) {

        if(session()->has('email_pengguna') && $request->input('simpan')) {

            $id_pengguna = session('id_pengguna');
            $id_pesanan  = $this->set_id_pesanan();
            $req = $request->all();

            $validasi = Validator::make($req, [
                'nama_penerima' => 'required|regex:/^[a-zA-Z\s]*$/|max:30',
                'alamat_tujuan' => 'required|string',
                'no_telepon'    => 'required|regex:/^[0-9\-\w\+]*$/|max:20',
                'keterangan'    => 'nullable|string',
                'service'       => 'required|alpha',
                'destinasi'     => 'required|regex:/^[a-zA-Z\,\.\s]*$/',
                'layanan'       => 'required|integer',
                'bank'          => 'required|alpha',
                'atas_nama'     => 'required|regex:/^[a-zA-Z\s]*$/|max:30',
                'no_rekening'   => 'required|regex:/^[0-9\-\s]*$/'
            ]);

            if($validasi->fails()){

                return back()->withErrors($validasi);

            }

            $keranjang = DB::table('tbl_keranjang')->where('id_pengguna', $id_pengguna);

            if($keranjang->exists()){

                $save_pesanan = DB::table('tbl_pesanan')->insert([
                    'id_pesanan'    => $id_pesanan,
                    'id_pengguna'   => $id_pengguna,
                    'nama_penerima' => $req['nama_penerima'],
                    'alamat_tujuan' => $req['alamat_tujuan'].'|'.$req['destinasi'],
                    'no_telepon'    => $req['no_telepon'],
                    'keterangan'    => !is_null($req['keterangan']) ? $req['keterangan'] : NULL,
                    'layanan'       => $req['service'],
                    'ongkos_kirim'  => $req['layanan'],
                    'total_bayar'   => $keranjang->sum('subtotal_biaya'),
                ]);

                DB::table('tbl_pembayaran')->insert([
                    'id_pesanan'       => $id_pesanan,
                    'id_pengguna'      => $id_pengguna,
                    'bank'             => $req['bank'],
                    'atas_nama'        => $req['atas_nama'],
                    'no_rekening'      => $req['no_rekening'],
                    'batas_pembayaran' => Carbon::tomorrow()
                ]);

                if($save_pesanan == True) {

                    foreach ($keranjang->get() as $item) {

                        $barang = DB::table('tbl_barang')->where('id_barang', $item->id_barang)->first();

                        DB::table('tbl_detail_pesanan')->insert([
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

                    DB::table('tbl_pesanan')->where('id_pesanan', $id_pesanan)->delete();

                    return back()->withErrors('Terjadi Kesalahan Saat Memproses Checkout');

                }

            } else {

                return back()->withErrors('Data Keranjang Tidak Ditemukan');

            }

        } else {

            return back()->withErrors('Terjadi Kesalahan Saat Menyimpan');

        }

    }

    protected function set_id_pesanan() {

        $data = DB::table('tbl_pesanan')->max('id_pesanan');

        if(!empty($data)) {

            $no_urut = substr($data, 9, 3) + 1;

            return 'PSN'.(new Datetime)->format('ymd').$no_urut;
        } else {
            return 'PSN'.(new Datetime)->format('ymd').'1';
        }
    }
}
