<?php

namespace App\Http\Controllers\Admin\Superadmin;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PenggunaController extends Controller
{
    public function index(Request $request) {

        if($request->session()->exists('email_admin') && session('superadmin') == true) {

            $data = DB::table('tbl_pengguna as akun')
                ->join('tbl_detail_pengguna as detail', 'detail.id_pengguna', 'akun.id_pengguna')
                ->select('akun.id_pengguna', 'akun.email', 'akun.tanggal_bergabung', 'detail.*')
                ->get();

            return view('admin.superadmin.pengguna.pengguna', ['data_pengguna' => $data]);

        } else {

            return redirect()->route('beranda_admin');

        }

    }

    public function hapus_pengguna(Request $request, $id_pengguna) {

        if($request->has('simpan') && session('superadmin') == true) {

            $data = DB::table('tbl_pengguna')->where('id_pengguna', $id_pengguna);

            $data->delete();

            return redirect()->route('superadmin_pengguna')->with('success', 'Akun Pengguna Berhasil Di Hapus');

        } else  {

            return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Data');

        }
    }

    public function get_pengguna(Request $request, $id_pengguna) {

        if($request->session()->exists('email_admin') && session('superadmin') == true) {

            $data = DB::table('tbl_pengguna as akun')
                ->join('tbl_detail_pengguna as detail', 'detail.id_pengguna', 'akun.id_pengguna')
                ->select('akun.id_pengguna', 'akun.email', 'akun.tanggal_bergabung', 'detail.*')
                ->where('akun.id_pengguna', $id_pengguna)
                ->first();

            return response()->json($data);

        } else {

            return redirect()->route('beranda_admin');

        }

    }

}
