<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index(Request $request, $id_admin) {

        if($request->session()->exists('email_admin')) {

            $data = DB::table('tbl_admin')->where('id_admin', $id_admin)->first();

            return view('admin.profile_admin', ['data_admin' => $data]);

        } else {

            return redirect()->route('login_admin')->with('fail', 'Harap Login Terlebih Dahulu');

        }

    }

    public function ganti_password(Request $request, $id_admin) {

        if($request->has('simpan')) {

            $validasi = Validator::make($request->all(), [
                'password_lama'         => 'required|alpha_num|max:18',
                'password_baru'         => 'required|alpha_num|max:18|confirmed',
                'password_baru_confirmation' => 'required|alpha_num|max:18'
            ]);

            $data = DB::table('tbl_admin')->where('id_admin', session('id_admin'))->first();

            if ($validasi->fails()) {

                return back()->withErrors($validasi);

            }

            if(Hash::check($request->input('password_lama'), $data->password) &&
              !Hash::check($request->input('password_baru'), $data->password)) {

                DB::table('tbl_admin')->where('id_admin', $id_admin)->update([
                    'password'  => Hash::make($request->input('password_baru'), [
                        'memory' => 1024,
                        'time' => 2,
                        'threads' => 2,
                    ]),
                ]);

                $request->session()->forget([
                    'id_admin',
                    'email_admin',
                    'nama_admin',
                    'foto_admin',
                    'superadmin'
                ]);

                return redirect()->route('login_admin')->with('success', 'Silahkan Login Kembali!');

            } else {

                return back()->withErrors('Password Yang Anda Masukan Tidak Memenuhi Ketentuan!');

            }

        } else {

            return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Harap Gunakan Tombol Simpan Untuk Menyimpan Data');

        }

    }
}
