<?php

namespace App\Http\Controllers\Pengguna\Keranjang;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use function GuzzleHttp\json_encode;

class KeranjangController extends Controller
{

    public function index(Request $request) {

        if(session()->has('id_pengguna')) {

            $data = DB::table('tbl_keranjang as keranjang')
                ->join('tbl_barang as barang', 'barang.id_barang', 'keranjang.id_barang')
                ->select('barang.*', 'keranjang.*')->where('id_pengguna', session('id_pengguna'))->get();

            $alamat = DB::table('tbl_detail_pengguna')->where('id_pengguna', session('id_pengguna'));

            return view('pengguna.keranjang.keranjang', [
                'data_keranjang' => $data,
                'alamat'         => $alamat,
            ]);

        } else {

            return redirect()->route('login')->withErrors('Harus Login Terlebih Dahulu');

        }

    }

    public function update(Request $request, $id_barang) {

        if($request->has('simpan')) {

            if($request->input('jumlah_beli') == 0){

                return back()->withErrors('Jumlah Pembelian Minimal 1 Pcs!');

            }

            $data = DB::table('tbl_keranjang')->where([
                ['id_barang', $id_barang],
                ['id_pengguna', session('id_pengguna')]
            ]);

            if($data->exists()){

                $barang = DB::table('tbl_barang')->where([
                    'id_barang' => $id_barang
                ])->first();

                if($barang->stok_barang < $request->input('jumlah_beli')){
                    return back()->withErrors('Jumlah beli melebihi stok!!');
                }

                $subtotal = $barang->harga_satuan * $request->input('jumlah_beli');

                $data->update([
                    'jumlah_beli'    => $request->input('jumlah_beli'),
                    'subtotal_biaya' => $subtotal,
                ]);

                return back()->with('success', 'Perubahan jumlah beli berhasil di proses');

            } else {

                return back()->withErrors('Terjadi kesalahan saat menyimpan, produk tidak ditemukan!');

            }

        } else {

            return redirect()->route('login')->withErrors('Harus Login Terlebih Dahulu');

        }

    }

    public function delete(Request $request, $id_barang){

        if($request->has('simpan')) {

            $data = DB::table('tbl_keranjang')->where([
                ['id_barang', $id_barang],
                ['id_pengguna', session('id_pengguna')]
            ]);

            if($data->exists()){

                $data->delete();

                return back()->with('success', 'Produk berhasil di hapus dari keranjang');

            } else {

                return back()->withErrors('Terjadi kesalahan saat menyimpan, produk tidak ditemukan!');

            }

        } else {

            return redirect()->route('login')->withErrors('Harus Login Terlebih Dahulu');

        }

    }

    public function method(Request $request) {

        if($request->has('simpan') && session()->has('email_pengguna')) {

            $validasi = Validator::make($request->all(), [
                'pilih_alamat' => 'required|integer|max:2'
            ]);

            if($validasi->fails()){
                return back()->withErrors($validasi);
            }

            $method = Crypt::encrypt($request->input('pilih_alamat'));

            return redirect()->route('checkout_keranjang', ['method' => $method]);

        } else {

            return redirect()->route('login')->withErrors('Harus Login Terlebih Dahulu');

        }

    }
}
