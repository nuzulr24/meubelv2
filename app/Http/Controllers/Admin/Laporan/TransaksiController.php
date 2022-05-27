<?php

namespace App\Http\Controllers\Admin\Laporan;

use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransaksiController extends Controller
{
    public function index(Request $request) {

        if (session()->has('email_admin')) {

            if(!empty($request->input('awal')) && !empty($request->input('akhir'))){

                $awal = $request->input('awal');
                $akhir = $request->input('akhir');

                $data = DB::table('tbl_pesanan')
                    ->where('status_pesanan', 5)
                    ->whereBetween('tanggal_pesanan', [$awal, $akhir])
                    ->get();

                return view('admin.laporan.transaksi', ['data_pesanan' => $data]);

            }

            return view('admin.laporan.transaksi');

        } else {

            return redirect()->route('login_admin')->withErrors('Harus login terlebih dahulu');

        }

    }

    public function print_transaksi(Request $request) {

        if (session()->has('email_admin')) {

            $validasi = Validator::make($request->all(), [
                'tanggal_awal'  => 'required|regex:/^[0-9\-]*/|max:10',
                'tanggal_akhir' => 'required|regex:/^[0-9\-]*/|max:10'
            ]);

            if($validasi->fails()){

                return back()->withErrors($validasi);

            }

            $tanggal_awal = $request->input('tanggal_awal');
            $tanggal_akhir = $request->input('tanggal_akhir');

            $data = DB::table('tbl_pesanan')
                ->where('status_pesanan', 5)
                ->whereBetween('tanggal_pesanan', [$tanggal_awal, $tanggal_akhir])
                ->get();

            return view('admin.laporan.print_transaksi', ['data_laporan' => $data]);

        } else {

            return redirect()->route('login_admin')->withErrors('Harus login terlebih dahulu');

        }

    }
}
