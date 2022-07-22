<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BerandaController extends Controller
{
    public function index(Request $request) {

        if($request->session()->exists('email_admin')) {

            $content = [
                'pengguna'              => DB::table('tbl_pengguna')->count(),
                'barang'                => DB::table('tbl_barang')->count(),
                'stok_mentah'           => DB::table('tbl_stock')->where('tipe_stok', 'Barang Mentah')->count(),
                'stok_setengah'           => DB::table('tbl_stock')->where('tipe_stok', 'Barang Setengah Jadi')->count(),
                'stok_jadi'           => DB::table('tbl_stock')->where('tipe_stok', 'Barang Jadi')->count(),
                'pendapatan_sekarang'   => DB::table('tbl_transaction')->where([
                                            ['created_at', 'LIKE', '%'.explode(' ', Carbon::now())[0].'%'],
                                            ['type', 'Transaksi Masuk']
                                        ])->sum('total_bayar'),
                'pendapatan_kemarin'  => DB::table('tbl_transaction')->where([
                                            ['created_at', 'LIKE', '%'.explode(' ', Carbon::now())[0].'%'],
                                            ['type', 'Transaksi Keluar']
                                        ])->sum('total_bayar'),
                'admin'                 => DB::table('tbl_admin')->where('diblokir', 0)->count()
            ];

            return view('admin.beranda', $content);

        } else {

            return redirect()->route('login_admin')->withErrors('Harus login terlebih dahulu');

        }

    }
}
