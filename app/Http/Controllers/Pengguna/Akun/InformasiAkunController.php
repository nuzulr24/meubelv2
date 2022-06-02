<?php

namespace App\Http\Controllers\Pengguna\Akun;

use Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InformasiAkunController extends Controller
{
    public function index(Request $request) {

        if(session()->has('email_pengguna')) {

            $data = DB::table('tbl_pengguna as pengguna')
                        ->join('tbl_detail_pengguna as detail', 'detail.id_pengguna', 'pengguna.id_pengguna')
                        ->select('pengguna.*', 'detail.*')
                        ->where('pengguna.id_pengguna', session('id_pengguna'))->first();

            return view('pengguna.akun.edit_informasi_akun', ['data_informasi' => $data]);

        } else {

            return redirect()->route('login')->withErrors('Harus Login Terlebih Dahulu');

        }

    }

    public function simpan_informasi(Request $request) {

        if(session()->has('email_pengguna') && $request->has('simpan')) {

            $validasi = Validator::make($request->all(), [
                'nama_lengkap'  => 'required|string|max:30',
                'jenis_kelamin' => 'required|alpha',
                'alamat_rumah'  => 'required|string',
                'email'         => 'required|email|max:30',
                'no_telepon'    => 'required|regex:/^[0-9\s\-\+]*$/|max:20',
            ]);

            if($validasi->fails()) {

                return back()->withErrors($validasi);

            }

            $data = DB::table('tbl_pengguna')->where('id_pengguna', session('id_pengguna'));

            if ($data->exists()) {

                $data->update([
                    'email'         =>  $request->input('email'),
                ]);

                $info_akun = DB::table('tbl_detail_pengguna')->where('id_pengguna', session('id_pengguna'))->first();

                DB::table('tbl_detail_pengguna')
                    ->where('id_pengguna', session('id_pengguna'))
                    ->update([
                        'nama_lengkap'  => $request->input('nama_lengkap'),
                        'jenis_kelamin' => $request->input('jenis_kelamin'),
                        'alamat_rumah'  => $request->input('alamat_rumah'),
                        'id_kecamatan'  => empty($request->input('kecamatan')) ? $info_akun->id_kecamatan : $request->input('kecamatan'),
                        'no_telepon'    => $request->input('no_telepon'),
                    ]);

                return redirect()->route('info_akun')->with('success', 'Informasi Akun Berhasil Di Simpan');

            } else {

                return redirect()->route('info_akun')->withErrors('Password Konfirmasi Salah');

            }

        }

    }
}
