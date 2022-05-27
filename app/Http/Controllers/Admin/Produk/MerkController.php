<?php

namespace App\Http\Controllers\Admin\Produk;

use DateTime;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MerkController extends Controller
{
    public function index(Request $request) {

        if($request->session()->exists('email_admin')) {

            $data = DB::table('tbl_merk')->get();

            return view('admin.produk.merk', ['data_merk' => $data]);

        } else {

            return redirect()->route('login_admin');

        }

    }

    public function tambah_merk(Request $request) {

        if($request->has('simpan')) {

            $validasi = Validator::make($request->all(), [
                'nama_merk' => 'required|regex:/^[a-zA-Z\s]*$/|max:30'
            ]);

            if ($validasi->fails()) {

                return back()->withErrors($validasi);

            }

            if(DB::table('tbl_merk')->where('nama_merk', $request->input('nama_merk'))->exists() == false) {

                DB::table('tbl_merk')->insert([
                    'id_merk'   => $this->set_id_merk(),
                    'nama_merk' => $request->input('nama_merk'),
                ]);

                return redirect()->route('merk_produk')->with('success', 'Merk Produk Berhasil Di Tambah');

            } else {

                return redirect()->route('merk_produk')->withErrors('Merk tidak dapat di gunakan karna telah tersedia');

            }

        } else {

            return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Harap Gunakan Tombol Simpan Untuk Menyimpan Data');

        }

    }

    public function edit_merk(Request $request, $id_merk) {

        if($request->has('simpan')) {

            $validasi = Validator::make($request->all(), [
                'nama_merk' => 'required|regex:/^[a-zA-Z\s]*$/|max:30'
            ]);

            if ($validasi->fails()) {

                return back()->withErrors($validasi);

            }

            if(DB::table('tbl_merk')->where('nama_merk', $request->input('nama_merk'))->exists() == false) {

                DB::table('tbl_merk')->where('id_merk', $id_merk)
                    ->update(['nama_merk' => $request->input('nama_merk')]);

                return redirect()->route('merk_produk')->with('success', 'Merk Produk Berhasil Di Rubah');

            } else {

                return back()->withErrors('Merk tidak dapat di gunakan karna telah tersedia');

            }

        } else {

            return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Harap Gunakan Tombol Simpan Untuk Menyimpan Data');

        }
    }

    public function hapus_merk(Request $request, $id_merk) {

        if($request->has('simpan')) {

            DB::table('tbl_merk')->where('id_merk', $id_merk)->delete();

            return redirect()->route('merk_produk')->with('success', 'Merk Produk Berhasil Di Hapus');

        } else {

            return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Harap Gunakan Tombol Simpan Untuk Menyimpan Data');

        }

    }

    public function get_merk(Request $request) {

        $id_merk = $request->input('id_merk');

        $data = DB::table('tbl_merk')->where('id_merk', $id_merk)->first();

        echo response()->json($data);
    }

    public function check_merk(){

        $nama_merk = str_replace('%20', ' ', $_GET['nama_merk']);

        $data = DB::table('tbl_merk')->where('nama_merk', $nama_merk)->exists();

        return response()->json($data);
    }

    protected function set_id_merk() {
        $data = DB::table('tbl_merk')->max('id_merk');

        if(!empty($data)) {

            $no_urut = substr($data, 9, 3) + 1;

            return 'MRK'.(new Datetime)->format('ymd').$no_urut;
        } else {
            return 'MRK'.(new Datetime)->format('ymd').'1';
        }
    }


}
