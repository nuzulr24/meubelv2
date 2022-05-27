<?php

namespace App\Http\Controllers\Pengguna\Pesanan;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PesananController extends Controller
{
    public function index(Request $request) {

        if(session()->has('email_pengguna')) {

            $data = DB::table('tbl_pesanan as pesanan')
            ->join('tbl_pembayaran as pembayaran', 'pembayaran.id_pesanan', 'pesanan.id_pesanan')
            ->select('pembayaran.*', 'pesanan.*')
            ->where([
                ['pesanan.id_pengguna', session('id_pengguna')],
                ['pesanan.status_pesanan', '<', 5]
            ])->get();

            return view('pengguna.pesanan.pesanan', ['data_pesanan' => $data]);

        } else {

            return redirect()->route('login')->withErrors('Harus login terlebih dahulu');

        }

    }

    public function dibatalkan(Request $request, $id_pesanan) {

        if(session()->has('email_pengguna') && $request->has('simpan')) {

            $data = DB::table('tbl_pesanan')->where([
                ['id_pengguna', session('id_pengguna')],
                ['id_pesanan', $id_pesanan]
            ]);

            if($data->exists()) {

                $data->update([
                    'dibatalkan'        => 1,
                    'status_pesanan'    => 1,
                    'no_resi'           => NULL,
                    'tanggal_dikirim'   => NULL
                ]);

                return redirect()->route('pesanan')->with('success', 'Pesanan berhasil di batalkan');

            } else {

                return back()->withErrors('Terjadi kesalahan saat menyimpan');

            }

        } else {

            return redirect()->route('login')->withErrors('Harus login terlebih dahulu');

        }

    }

    public function invoice(Request $request, $id_invoice){

        if(session()->has('email_pengguna')) {

            $data = DB::table('tbl_invoice as invoice')
                ->join('tbl_pembayaran as pembayaran', 'pembayaran.id_pesanan', 'invoice.id_pesanan')
                ->join('tbl_pesanan as pesanan', 'pesanan.id_pesanan', 'invoice.id_pesanan')
                ->select('invoice.*', 'pembayaran.*', 'pesanan.*')
                ->where([['invoice.id_pengguna', session('id_pengguna')], ['invoice.id_invoice', $id_invoice]])->first();

            $detail_pesanan = DB::table('tbl_detail_pesanan as detail')
                ->join('tbl_barang as barang', 'barang.id_barang', 'detail.id_barang')
                ->select('detail.*', 'barang.*')
                ->where('detail.id_pesanan', $data->id_pesanan)->get();

            return view('pengguna.pesanan.invoice', ['data_invoice' => $data, 'detail_pesanan' => $detail_pesanan]);

        } else {

            return redirect()->route('login')->withErrors('Harus login terlebih dahulu');

        }

    }

    public function detail_pesanan(Request $request, $id_pesanan) {

        if(session()->has('email_pengguna')) {

            $data = DB::table('tbl_pesanan as pesanan')
            ->join('tbl_pembayaran as pembayaran', 'pembayaran.id_pesanan', 'pesanan.id_pesanan')
            ->select('pembayaran.*', 'pesanan.*')
            ->where([['pesanan.id_pengguna', session('id_pengguna')], ['pesanan.id_pesanan', $id_pesanan]])->first();

            $detail_pesanan = DB::table('tbl_detail_pesanan as detail')
                ->join('tbl_barang as barang', 'barang.id_barang', 'detail.id_barang')
                ->select('detail.*', 'barang.*')
                ->where('detail.id_pesanan', $data->id_pesanan)->get();

            return view('pengguna.pesanan.detail_pesanan', ['data_detail' => $data, 'detail_pesanan' => $detail_pesanan]);

        } else {

            return redirect()->route('login')->withErrors('Harus login terlebih dahulu');

        }

    }

    public function konfirmasi_pesanan(Request $request, $id_pesanan) {

        if(session()->has('email_pengguna') && $request->has('simpan')) {

            DB::table('tbl_pesanan')->where('id_pesanan', $id_pesanan)->update([
                'status_pesanan'    => 4,
                'tanggal_diterima'  => Carbon::now(),
            ]);

            return redirect()->route('pesanan')->with('success', 'Pesanan '.$id_pesanan.' berhasil di konfirmasi.');

        } else {

            return redirect()->route('login')->withErrors('Harus login terlebih dahulu');

        }

    }

    public function riwayat_pesanan(Request $request) {

        if(session()->has('email_pengguna')) {

            $data = DB::table('tbl_pesanan as pesanan')
            ->join('tbl_pembayaran as pembayaran', 'pembayaran.id_pesanan', 'pesanan.id_pesanan')
            ->select('pembayaran.*', 'pesanan.*')
            ->where([
                ['pesanan.id_pengguna', session('id_pengguna')],
                ['pesanan.status_pesanan', 5]
            ])->get();

            return view('pengguna.pesanan.riwayat_pesanan', ['data_pesanan' => $data, 'inv' => NULL]);

        } else {

            return redirect()->route('login')->withErrors('Harus login terlebih dahulu');

        }
    }
}
