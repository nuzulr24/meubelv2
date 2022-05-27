<?php

namespace App\Http\Controllers\Pengguna\Produk;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DetailProdukController extends Controller
{
    public function index(Request $request, $id_barang) {

        $data = DB::table('tbl_barang')->where('id_barang', $id_barang);

        if($data->exists()) {

            return view('pengguna.produk.detailproduk', ['detail' => $data->first()]);

        } else {

            return redirect()->route('produk')->withErrors('Gagal Melihat Produk');

        }

    }

    public function masukan_keranjang(Request $request, $id_barang) {

        if($request->has('simpan')) {

            if(!session()->has('id_pengguna')) {

                return redirect()->route('login')->withErrors('Harus Login Terlebih Dahulu');

            }

            if($request->input('jumlah_beli') == 0){

                return back()->withErrors('Jumlah Pembelian Minimal 1 Pcs');

            }

            $data = DB::table('tbl_barang')->where('id_barang', $id_barang);

            if($data->exists() && $data->first()->stok_barang != 0) {

                $total = [
                    'biaya' => $data->first()->harga_satuan * $request->input('jumlah_beli'),
                    'stok'  => $data->first()->stok_barang - $request->input('jumlah_beli')
                ];

                if($total['stok'] == 0 || $data->first()->stok_barang < $request->input('jumlah_beli')) {

                    return back()->withErrors('Stok barang tidak mencukupi');

                }

                $keranjang = DB::table('tbl_keranjang')->where([
                    'id_pengguna'   => session('id_pengguna'),
                    'id_barang'     => $id_barang
                ]);

                if($keranjang->exists()) {

                    $data_keranjang = $keranjang->first();

                    $total_baru = [
                        'biaya'       => $data_keranjang->subtotal_biaya + $total['biaya'],
                        'jumlah_beli' => $data_keranjang->jumlah_beli + $request->input('jumlah_beli')
                    ];

                    DB::table('tbl_keranjang')->where([
                        'id_pengguna'       => session('id_pengguna'),
                        'id_barang'         => $id_barang
                    ])->update([
                        'jumlah_beli'       => $total_baru['jumlah_beli'],
                        'subtotal_biaya'    => $total_baru['biaya']
                    ]);

                    return back()->with('success', $data->first()->nama_barang.' berhasil di tambahkan ke keranjang');

                } else {

                    DB::table('tbl_keranjang')->insert([
                        'id_pengguna'       => session('id_pengguna'),
                        'id_barang'         => $id_barang,
                        'jumlah_beli'       => $request->input('jumlah_beli'),
                        'subtotal_biaya'    => $total['biaya']
                    ]);

                    return back()->with('success', $data->first()->nama_barang.' berhasil di tambahkan ke keranjang');

                }

            } else {

                return back()->withErrors('Barang tidak ditemukan atau stok barang kosong');

            }

        } else {

            return back()->withErrors('Terjadi kesalahan saat menyimpan');

        }

    }
}
