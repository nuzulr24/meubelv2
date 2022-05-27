<?php

namespace App\Http\Controllers\Pengguna\Autentikasi;

use DateTime;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function index(Request $request) {

        (!$request->session()->exists('email') ? true : redirect()->route('beranda'));

        return view('pengguna.autentikasi.register');
    }

    public function register(Request $request) {

        if($request->input('simpan')) {

            $validasi = Validator::make($request->all(), [
                'nama_lengkap'          => 'required|regex:/^[a-zA-Z\s]*$/|max:30',
                'jenis_kelamin'         => 'required|alpha',
                'email'                 => 'required|email|unique:tbl_pengguna|max:30',
                'password'              => 'required|alpha_num|max:18|confirmed',
                'password_confirmation' => 'required|alpha_num|max:18',
            ]);

            if($validasi->fails()) {

                return back()->withErrors($validasi);

            }

            $id_pengguna = $this->set_id_pengguna();

            DB::table('tbl_pengguna')->insert([
                'id_pengguna'   =>  $id_pengguna,
                'email'         =>  $request->input('email'),
                'password'      =>  Hash::make($request->input('password')),
            ]);

            DB::table('tbl_detail_pengguna')->insert([
                'id_pengguna'   => $id_pengguna,
                'nama_lengkap'  => $request->input('nama_lengkap'),
                'jenis_kelamin' => $request->input('jenis_kelamin')
            ]);

            return redirect()->route('register')->with('success', 'Registrasi Berhasil');

        } else {

            return back()->withErrors('Terjadi Kesalahan Saat Menyimpan');

        }
    }

    protected function set_id_pengguna(){

        $data = DB::table('tbl_pengguna')->max('id_pengguna');

        if(!empty($data)) {

            $no_urut = substr($data, 9, 3) + 1;

            return 'PGN'.(new Datetime)->format('ymd').$no_urut;

        } else {

            return 'PGN'.(new Datetime)->format('ymd').'1';

        }
    }
}
