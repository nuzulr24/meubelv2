<?php

namespace App\Http\Controllers\Admin\Transaksi;

use DateTime;
use validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PengirimanController extends Controller
{
    public function index(Request $request) {

        if ($request->session()->exists('email_admin')) {

            $data = DB::table('tbl_pesanan')
                ->select(
                    'id_pesanan', 'nama_penerima', 'alamat_tujuan', 'layanan', 'tanggal_diterima',
                    'no_telepon', 'no_resi', 'status_pesanan', 'tanggal_dikirim', 'kurir', 'layanan', 'kurir_cod'
                )->get();

            return view('admin.transaksi.pengiriman', ['data_pengiriman' => $data]);

        } else {

            return redirect()->route('login_admin')->with('fail', 'Harap Login Terlebih Dahulu');

        }

    }

    public function batalkan_pesanan(Request $request, $id_pesanan) {

        if($request->has('simpan') == true) {

            $data = DB::table('tbl_pesanan')->where('id_pesanan', $id_pesanan);

            $status = $data->first()->dibatalkan;

            if($data->exists()) {

                $data->update([
                    'dibatalkan'        => 1,
                    'status_pesanan'    => 1,
                    'no_resi'           => NULL,
                    'tanggal_dikirim'   => NULL
                ]);

                return redirect()->route('pengiriman_admin')->with('success',
                    $status == 0 ? 'Pesanan Berhasil Di Batalkan' : 'Pembatalan Pesanan Berhasil Di Cabut');

            } else {

                return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Data');

            }

        } else {

            return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Data');

        }

    }

    public function selesai(Request $request, $id_pesanan) {

        if ($request->session()->exists('email_admin')) {

            $data = DB::table('tbl_pesanan')->where([
                'id_pesanan'        => $id_pesanan,
                'status_pesanan'    => 4
            ]);

            if(!empty($data->first())) {

                $data->update(['status_pesanan' => 5]);

                DB::table('tbl_pembayaran')
                    ->where('id_pesanan', $id_pesanan)
                    ->update(['selesai' => 1]);
            }

            return back()->with('success', 'Pesanan Dengan ID '.$id_pesanan.' Telah Selesai');

        } else {

            return redirect()->route('login_admin')->with('fail', 'Harap Login Terlebih Dahulu');

        }

    }
}
