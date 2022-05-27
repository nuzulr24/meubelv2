<?php

namespace App\Http\Controllers\Pengguna\Akun;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AkunController extends Controller
{
    public function index(Request $request) {

        if($request->session()->exists('email_pengguna')) {

            $data = DB::table('tbl_pengguna as pengguna')
                ->join('tbl_detail_pengguna as detail', 'detail.id_pengguna', 'pengguna.id_pengguna')
                ->select('pengguna.*', 'detail.*')
                ->where('pengguna.id_pengguna', session('id_pengguna'))->first();

            return view('pengguna.akun.akunpengguna', ['data_pengguna' => $data]);

        } else {

            return redirect()->route('login')->withErrors('Harus Login Terlebih Dahulu');

        }
    }
}
