<?php

namespace App\Http\Controllers\Admin\Produk;

use DateTime;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class KategoriController extends Controller
{
    public function index(Request $request) {

        if($request->session()->exists('email_admin')) {

            $data = DB::table('tbl_kategori')->get();

            return view('admin.produk.kategori', ['data_kategori' => $data]);

        } else {

            return redirect()->route('login_admin');

        }
    }

    public function tambah_kategori(Request $request) {

        if($request->has('simpan')) {

            $validasi = Validator::make($request->all(), [
                'nama_kategori' => 'required|regex:/^[a-zA-Z\s]*$/|max:30',
                'foto' => 'required|mimes:jpg,jpeg,png'
            ]);

            if ($validasi->fails()) {

                return back()->withErrors($validasi);

            }

            if(DB::table('tbl_kategori')->where('nama_kategori', $request->input('nama_kategori'))->exists() == false) {

                $save_favicon = Storage::putFileAs(
                'public/kategori/', $request->file('foto'), $request->file('foto')->getClientOriginalName());

                DB::table('tbl_kategori')->insert([
                    'id_kategori'   => $this->set_id_kategori(),
                    'nama_kategori' => $request->input('nama_kategori'),
                    'foto' => $request->file('foto')->getClientOriginalName()
                ]);

                return redirect()->route('kategori_produk')->with('success', 'kategori Produk Berhasil Di Tambah');

            } else {

                return back()->withErrors('Kategori tidak dapat di gunakan karna telah tersedia');

            }

        } else {

            return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Harap Gunakan Tombol Simpan Untuk Menyimpan Data');

        }

    }

    public function edit_kategori(Request $request, $id_kategori) {

        if($request->has('simpan')) {

            $validasi = Validator::make($request->all(), [
                'nama_kategori' => 'required|regex:/^[a-zA-Z\s]*$/|max:30'
            ]);

            if ($validasi->fails()) {

                return back()->withErrors($validasi);

            }

            if(DB::table('tbl_kategori')->where('nama_kategori', $request->input('nama_kategori'))->exists() == true) {

                $data = DB::table('tbl_kategori')->select('foto')->where('id_kategori', $id_kategori)->first();

                if($request->hasFile('foto')) {

                    Storage::delete('public/kategori/'.$data->foto);

                    $save_foto = Storage::putFileAs(
                        'public/kategori/',
                        $request->file('foto'), $request->file('foto')->getClientOriginalName()
                    );

                    $foto_produk = basename($save_foto);

                }

                DB::table('tbl_kategori')->where('id_kategori', $id_kategori)
                    ->update([
                        'nama_kategori' => $request->input('nama_kategori'),
                        'foto' => $request->hasFile('foto') ? $foto_produk : $data->foto
                    ]);

                return redirect()->route('kategori_produk')->with('success', 'Kategori Produk Berhasil Di Rubah');
                
                // echo $id_kategori;

            } 

        } else {

            // return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Harap Gunakan Tombol Simpan Untuk Menyimpan Data');

        }
    }

    public function hapus_kategori(Request $request, $id_kategori) {

        if($request->has('simpan')) {
            $data = DB::table('tbl_kategori')->select('foto')->where('id_kategori', $id_kategori)->first();
            Storage::delete('public/kategori/'.$data->foto);
            DB::table('tbl_kategori')->where('id_kategori', $id_kategori)->delete();

            return redirect()->route('kategori_produk')->with('success', 'Kategori Produk Berhasil Di Hapus');

        } else {

            return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Harap Gunakan Tombol Simpan Untuk Menyimpan Data');

        }

    }

    public function get_kategori(Request $request) {

        $id_kategori = $request->input('id_kategori');

        $data = DB::table('tbl_kategori')->where('id_kategori', $id_kategori)->first();

        return response()->json($data);
    }

    protected function set_id_kategori() {
        $data = DB::table('tbl_kategori')->max('id_kategori');

        if(!empty($data)) {

            $no_urut = substr($data, 9, 3) + 1;

            return 'KTG'.(new Datetime)->format('ymd').$no_urut;
        } else {
            return 'KTG'.(new Datetime)->format('ymd').'1';
        }
    }
}
