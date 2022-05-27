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
                'barang'                => DB::table('tbl_barang')->where('stok_barang', '>', 0)->count(),
                'pendapatan_sekarang'   => DB::table('tbl_pesanan')->where([
                                            ['tanggal_pesanan', 'LIKE', '%'.explode(' ', Carbon::now())[0].'%'],
                                            ['status_pesanan', '>', '3']
                                        ])->sum('total_bayar'),
                'pendapatan_kemarin'  => DB::table('tbl_pesanan')->where([
                                            ['tanggal_pesanan', 'LIKE', '%'.explode(' ', Carbon::yesterday())[0].'%'],
                                            ['status_pesanan', '>', '3']
                                        ])->sum('total_bayar'),
                'admin'                 => DB::table('tbl_admin')->where('diblokir', 0)->count()
            ];

            return view('admin.beranda', $content);

        } else {

            return redirect()->route('login_admin')->withErrors('Harus login terlebih dahulu');

        }

    }
}
