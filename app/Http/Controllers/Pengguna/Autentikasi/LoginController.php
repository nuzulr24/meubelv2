<?php

namespace App\Http\Controllers\Pengguna\Autentikasi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function index(Request $request) {

        (!$request->session()->exists('email_pengguna') ? true : redirect()->route('beranda'));

        return view('pengguna.autentikasi.login');
    }

    public function login(Request $request) {

        if($request->has('simpan')) {

            $data = DB::table('tbl_pengguna')
                ->join('tbl_detail_pengguna', 'tbl_detail_pengguna.id_pengguna', '=', 'tbl_pengguna.id_pengguna')
                ->select('tbl_pengguna.*', 'tbl_detail_pengguna.nama_lengkap')
                ->where('email', $request->input('email'))->first();

            if(!empty($data) && Hash::check($request->input('password'), $data->password)) {

                session([
                    'id_pengguna'       => $data->id_pengguna,
                    'email_pengguna'    => $data->email,
                    'nama_lengkap'      => $data->nama_lengkap
                ]);

                return redirect()->route('beranda');

            } else {

                return back()->withErrors('Email atau Password Salah!');

            }

        } else {

            return back()->withErrors('Terjadi Kesalahan Saat Masuk');

        }
    }

    public function logout(Request $request) {

        if ($request->session()->exists('email_pengguna')) {

            $request->session()->forget([
                'id_pengguna',
                'email_pengguna',
                'nama_lengkap',
            ]);

            return redirect()->route('login')->with('success', 'Anda telah logout');
        }

        return redirect()->route('beranda');
    }
}
