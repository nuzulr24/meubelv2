<?php

namespace App\Http\Controllers\Admin\Stok;

use DateTime;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class StokController extends Controller
{
    public function index(Request $request) {

        if($request->session()->exists('email_admin')) {

            $data = DB::table('tbl_stock')->get();

            return view('admin.stok.index', ['data_stok' => $data]);

        } else {

            return redirect()->route('login_admin');

        }
    }

    public function tambah_stok(Request $request) {

        $validasi = Validator::make($request->all(), [
            'nama_kategori' => 'required',
            'tipe_barang' => 'required',
            'jumlah_stok' => 'required|integer'
        ]);

        if ($validasi->fails()) {

            return back()->withErrors($validasi);

        }

        if(DB::table('tbl_stock')->where('nama', $request->input('nama_kategori'))->exists() == false) {
            DB::table('tbl_stock')->insert([
                'nama'   => $request->input('nama_kategori'),
                'tipe_stok' => $request->input('tipe_barang'),
                'jumlah_stok' => $request->input('jumlah_stok')
            ]);

            return redirect()->route('list_stok')->with('success', 'Stok Produk Berhasil Di Tambah');

        } else {

            return back()->withErrors('Stok tidak dapat di gunakan karna telah tersedia');

        }
    }

    public function pindah_produk(Request $request, $id_kategori) {

        $validasi = Validator::make($request->all(), [
            'nama_kategori' => 'required',
            'id_kategori' => 'required',
            'id_merk' => 'required',
            'harga' => 'required|integer'
        ]);

        if ($validasi->fails()) {

            return back()->withErrors($validasi);

        }

        if(DB::table('tbl_barang')->where('nama_barang', $request->input('nama_kategori'))->exists() == false) {
            $id_barang = $this->set_id_barang();

            DB::table('tbl_barang')->insert([
                'id_barang'         => $id_barang,
                'nama_barang'       => $request->input('nama_kategori'),
                'id_kategori'       => $request->input('id_kategori'),
                'id_merk'       => $request->input('id_merk'),
                'harga_satuan' => $request->input('harga'),
                'stok_barang'       => DB::table('tbl_stock')->where('nama', $request->input('nama_kategori'))->first()->jumlah_stok,
            ]);

            DB::table('tbl_stock')->where('id', $id_kategori)->delete();

            return redirect()->route('list_stok')->with('success', 'Stok Produk Berhasil Dipindah');

        } else {

            return back()->withErrors('Stok tidak dapat di gunakan karna telah tersedia');

        }
    }

    public function edit_stok(Request $request, $id_kategori) {
        if($request->has('simpan')) {

            $validasi = Validator::make($request->all(), [
                'nama_kategori' => 'required|max:30',
                'jumlah_stok' => 'required|integer'
            ]);

            if ($validasi->fails()) {

                return back()->withErrors($validasi);

            }

            if(DB::table('tbl_stock')->where('nama', $request->input('nama_kategori'))->exists() == true) {

                DB::table('tbl_stock')->where('id', $id_kategori)
                    ->update([
                        'nama'   => $request->input('nama_kategori'),
                        'jumlah_stok' => $request->input('jumlah_stok')
                    ]);

                return redirect()->route('list_stok')->with('success', 'Stok barang Berhasil Di Rubah');
                
                // echo $id_kategori;
            } 

        } else {

            return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Harap Gunakan Tombol Simpan Untuk Menyimpan Data');

        }
    }

    public function hapus_stok(Request $request, $id_kategori) {

        if($request->has('simpan')) {
            DB::table('tbl_stock')->where('id', $id_kategori)->delete();

            return redirect()->route('list_stok')->with('success', 'Stok Barang Berhasil Di Hapus');

        } else {

            return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Harap Gunakan Tombol Simpan Untuk Menyimpan Data');

        }

    }

    public function get_kategori(Request $request) {

        $id_kategori = $request->input('id_kategori');

        $data = DB::table('tbl_kategori')->where('id_kategori', $id_kategori)->first();

        return response()->json($data);
    }

    protected function set_id_barang() {
        $data = DB::table('tbl_barang')->max('id_barang');

        if(!empty($data)) {

            $no_urut = substr($data, 9, 3) + 1;

            return 'BRG'.(new Datetime)->format('ymd').$no_urut;
        } else {
            return 'BRG'.(new Datetime)->format('ymd').'1';
        }
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
