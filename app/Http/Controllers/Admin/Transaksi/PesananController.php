<?php

namespace App\Http\Controllers\Admin\Transaksi;

use DateTime;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PesananController extends Controller
{
    /**
     * STATUS PESANAN
     * ==============================
     * - 0 => Belum Di Proses
     * - 1 => Telah Di Verifikasi
     * - 2 => Sedang Di Proses
     * - 3 => Telah Di Kirim
     * - 4 => Telah Di Terima
     * - 5 => Selesai
     */

    public function index(Request $request) {

        if($request->session()->exists('email_admin')) {

            $stat_label = [
                'bg-gray', 'label-info', 'bg-blue',
                // 'bg-navy', 'bg-orange', 'bg-green'
            ];

            $stat_notif = [
                'Belum Di Proses', 'Sedang Di Proses', 'Siap Dikirim',
                // 'Telah Di Kirim', 'Telah Di Terima', 'Selesai'
            ];

            $data = DB::table('tbl_pesanan as pesanan')
                ->join('tbl_pembayaran as pembayaran', 'pembayaran.id_pesanan', 'pesanan.id_pesanan')
                ->select('pesanan.*', 'pembayaran.*')
                ->get();

            return view('admin.transaksi.pesanan', [
                'data_pesanan'  => $data,
                'stat_label'    => $stat_label,
                'stat_notif'    => $stat_notif
            ]);

        } else {

            return redirect()->route('login_admin')->with('fail', 'Harap Login Terlebih Dahulu');

        }

    }

    public function detail_pesanan(Request $request, $id_pesanan) {

        if($request->session()->exists('email_admin')) {

            $status = [
                'Belum Di Proses',
                'Telah Di Verifikasi',
                'Sedang Di Proses',
                'Telah Di Kirim',
                'Telah Di Terima',
                'Selesai'
            ];

            $data_pesanan = DB::table('tbl_pesanan')->where('id_pesanan', $id_pesanan)->first();
            $data_pembayaran = DB::table('tbl_pembayaran')->where('id_pesanan', $id_pesanan)->first();
            $data_detail  = DB::table('tbl_detail_pesanan')
                ->join('tbl_barang', 'tbl_barang.id_barang', 'tbl_detail_pesanan.id_barang')
                ->select('tbl_barang.*', 'tbl_detail_pesanan.*')
                ->where('tbl_detail_pesanan.id_pesanan', $id_pesanan)->get();

            return view('admin.transaksi.detail_pesanan', [
                'data_pesanan'  => $data_pesanan,
                'pembayaran'    => $data_pembayaran,
                'data_detail'   => $data_detail,
                'status'        => $status,
                'invoice'       => true
            ]);

        } else {

            return redirect()->route('login_admin')->with('fail', 'Harap Login Terlebih Dahulu');

        }

    }

    public function edit_pesanan(Request $request, $id_pesanan) {

        if ($request->has('simpan')) {

            $validasi = Validator::make($request->all(), [

                'nama_penerima' => 'required|regex:/^[a-zA-Z\s]*$/|max:40',
                'alamat_tujuan' => 'required|string',
                'no_telepon'    => 'required|regex:/^[0-9\-\+\s]*$/|max:18',

            ]);

            if($validasi->fails()) {

                return back()->withErrors($validasi);

            }

            $data = DB::table('tbl_pesanan')->where('id_pesanan', $id_pesanan);

            if($data->first()->status_pesanan <= 2) {

                $data->update([

                    'nama_penerima' => $request->input('nama_penerima'),
                    'alamat_tujuan' => $request->input('alamat_tujuan'),
                    'no_telepon'    => $request->input('no_telepon')

                ]);

                return redirect()->route('pesanan_admin')->with('success', 'Data Pengiriman Berhasil Di Simpan');

            } else {

                return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Data');

            }

        } else {

            return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Data Harap Gunakan Tombol Simpan');

        }
    }

    public function proses_pesanan(Request $request, $id_pesanan) {

        if($request->has('simpan') == true) {

            $data = DB::table('tbl_pesanan')->where('id_pesanan', $id_pesanan);

            $status = $data->first()->status_pesanan;

            if($status <= 2) {

                $data->update([
                    'status_pesanan'    => $status == 1 ? 2 : 1,
                ]);

                return redirect()->route('pesanan_admin')->with('success', 'Status Berhasil DI Rubah');

            } else {

                return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Data');

            }

        } else {

            return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Data');

        }
    }

    public function kirim_pesanan(Request $request, $id_pesanan) {

        if($request->has('simpan') == true) {

            $validasi = Validator::make($request->all(), [

                'resi'  => 'required|alpha_num|max:20'

            ]);

            if($validasi->fails()) {

                return back()->withErrors($validasi);

            }

            $data = DB::table('tbl_pesanan')->where('id_pesanan', $id_pesanan);

            $status = $data->first()->status_pesanan;

            if($status <= 3 && $status > 1) {

                $data->update([
                    'no_resi'           => $status == 2 ? $request->input('resi') : NULL,
                    'status_pesanan'    => $status == 2 ? 3 : 2,
                    'tanggal_dikirim'   => $status == 2 ? (new DateTime)->format('Y-m-d H:m:s') : NULL
                ]);

                return redirect()->route('pesanan_admin')->with('success',
                    $status == 2 ? 'Pesanan Berhasil DI Proses' : 'Proses Pesanan Berhasil Di Batalkan');

            } else {

                return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Data');

            }

        } else {

            return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Data');

        }

    }

    public function batalkan_pesanan(Request $request, $id_pesanan) {

        if($request->has('simpan') == true) {

            $data = DB::table('tbl_pesanan')->where('id_pesanan', $id_pesanan);

            $status = $data->first()->dibatalkan;

            if($data->first()->status_pesanan < 3) {

                $data->update([
                    'dibatalkan' => $status == 0 ? 1 : 0,
                ]);

                return redirect()->route('pesanan_admin')->with('success',
                    $status == 0 ? 'Pesanan Berhasil Di Batalkan' : 'Pembatalan Pesanan Berhasil Di Cabut');

            } else {

                return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Data');

            }

        } else {

            return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Data');

        }

    }

    public function hapus_pesanan(Request $request, $id_pesanan) {

        if($request->has('simpan') == true) {

            $data = DB::table('tbl_pesanan')->where('id_pesanan', $id_pesanan);

            if($data->first()->status_pesanan < 3) {

                $data->delete();

                return redirect()->route('pesanan_admin')->with('success', 'Pesanan Berhasil Di Hapus');

            } else {

                return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Data');

            }

        } else {

            return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Data');

        }

    }

    public function get_info_penerima(Request $request, $id_pesanan) {

        if($request->session()->exists('email_admin')) {

            $data = DB::table('tbl_pesanan')->where('id_pesanan', $id_pesanan)->first();

            return response()->json($data);

        } else {

            return redirect()->route('login_admin')->with('fail', 'Harap Login Terlebih Dahulu');

        }

    }

}
