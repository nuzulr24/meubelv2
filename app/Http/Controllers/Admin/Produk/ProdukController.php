<?php

namespace App\Http\Controllers\Admin\Produk;

use DateTime;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class ProdukController extends Controller
{
    public function index(Request $request) {

        if($request->session()->exists('email_admin')) {

            if(!empty($request->input('merk')) && !empty($request->input('kategori'))) {

                $id_kategori = DB::table('tbl_kategori')->where('nama_kategori', ucfirst($request->input('kategori')))->first();
                $id_merk = DB::table('tbl_merk')->where('nama_merk', ucfirst($request->input('merk')))->first();

                $data = DB::table('tbl_barang')
                    ->join('tbl_kategori', 'tbl_kategori.id_kategori', 'tbl_barang.id_kategori')
                    ->join('tbl_merk', 'tbl_merk.id_merk', 'tbl_barang.id_merk')
                    ->select('tbl_barang.*', 'tbl_kategori.*', 'tbl_merk.*')
                    ->where([
                        ['tbl_merk.id_merk', $id_merk->id_merk],
                        ['tbl_kategori.id_kategori', $id_kategori->id_kategori]
                    ])->get();

            } else if (!empty($request->input('kategori'))) {

                $id_kategori = DB::table('tbl_kategori')->where('nama_kategori', ucfirst($request->input('kategori')))->first();

                $data = DB::table('tbl_barang')
                    ->join('tbl_kategori', 'tbl_kategori.id_kategori', 'tbl_barang.id_kategori')
                    ->join('tbl_merk', 'tbl_merk.id_merk', 'tbl_barang.id_merk')
                    ->select('tbl_barang.*', 'tbl_kategori.*', 'tbl_merk.*')
                    ->where('tbl_kategori.id_kategori', $id_kategori->id_kategori)->get();

            } else if(!empty($request->input('merk'))) {

                $id_merk = DB::table('tbl_merk')->where('nama_merk', ucfirst($request->input('merk')))->first();

                $data = DB::table('tbl_barang')
                    ->join('tbl_kategori', 'tbl_kategori.id_kategori', 'tbl_barang.id_kategori')
                    ->join('tbl_merk', 'tbl_merk.id_merk', 'tbl_barang.id_merk')
                    ->select('tbl_barang.*', 'tbl_kategori.nama_kategori', 'tbl_merk.*')
                    ->where('tbl_merk.id_merk', $id_merk->id_merk)->get();

            } else {

                $data = DB::table('tbl_barang')
                    ->join('tbl_kategori', 'tbl_kategori.id_kategori', 'tbl_barang.id_kategori')
                    ->join('tbl_merk', 'tbl_merk.id_merk', 'tbl_barang.id_merk')
                    ->select('tbl_barang.*', 'tbl_kategori.nama_kategori', 'tbl_merk.nama_merk')
                    ->get();
            }


            $merk = DB::table('tbl_merk')->get();
            $kategori = DB::table('tbl_kategori')->get();

            return view('admin.produk.produk', ['data_produk'   => $data,
                                                'data_merk'     => $merk,
                                                'data_kategori' => $kategori]);

        } else {

            return redirect()->route('login_admin')->with('fail', 'Harap Login Terlebih Dahulu');

        }

    }

    public function tambah_produk(Request $request) {

        if($request->has('simpan')) {

            $validasi = Validator::make($request->all(), [
                'nama_barang'       => 'required|regex:/^[a-zA-Z0-9\s]*$/|max:50',
                'deskripsi_barang'  => 'required',
                'berat_barang'      => 'required|integer',
                'harga_satuan'      => 'required|integer',
                'stok_barang'       => 'required|integer',
                'foto_barang'       => 'required|mimes:jpg,jpeg,png'
            ]);

            if ($validasi->fails()) {

                return back()->withErrors($validasi);

            }

            if(DB::table('tbl_barang')->where('nama_barang', $request->input('nama_barang'))->exists() == false) {

                $id_barang = $this->set_id_barang();

                $extension = $request->file('foto_barang')->getClientOriginalExtension();

                $foto_produk = Storage::putFileAs(
                    'public/produk/',
                    $request->file('foto_barang'), $id_barang.'.'.$extension
                );

                DB::table('tbl_barang')->insert([
                    'id_barang'         => $id_barang,
                    'nama_barang'       => $request->input('nama_barang'),
                    'id_kategori'       => $request->input('id_kategori'),
                    'id_merk'           => $request->input('id_merk'),
                    'deskripsi_barang'  => $request->input('deskripsi_barang'),
                    'berat_barang'      => $request->input('berat_barang'),
                    'harga_satuan'      => $request->input('harga_satuan'),
                    'stok_barang'       => $request->input('stok_barang'),
                    'foto_barang'       => basename($foto_produk),
                ]);

                return redirect()->route('list_produk')->with('success', 'Produk Berhasil DI Simpan');

            } else {

                return back()->withErrors('Produk tidak dapat di simpan karna telah tersedia');
            }

        } else {

            return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Harap Gunakan Tombol Simpan Untuk Menyimpan Data');

        }

    }

    public function edit_produk(Request $request, $id_barang) {

        if($request->has('simpan')) {

            $validasi = Validator::make($request->all(), [
                'nama_barang'   => 'required|regex:/^[a-zA-Z0-9\s]*$/|max:50',
                'berat_barang'  => 'required|integer',
                'harga_satuan'  => 'required|integer',
                'stok_barang'   => 'required|integer',
            ]);

            if ($validasi->fails()) {

                return back()->withErrors($validasi);

            }

            $data = DB::table('tbl_barang')->select('foto_barang')->where('id_barang', $id_barang)->first();

            if($request->hasFile('foto_barang')) {

                Storage::delete('public/produk/'.$data->foto_barang);

                $extension = $request->file('foto_barang')->getClientOriginalExtension();

                $save_foto = Storage::putFileAs(
                    'public/produk/',
                    $request->file('foto_barang'), $id_barang.'.'.$extension
                );

                $foto_produk = basename($save_foto);

            }

            DB::table('tbl_barang')->where('id_barang', $id_barang)
                ->update([
                    'nama_barang'   => $request->input('nama_barang'),
                    'id_kategori'   => $request->input('id_kategori'),
                    'id_merk'       => $request->input('id_merk'),
                    'berat_barang'  => $request->input('berat_barang'),
                    'harga_satuan'  => $request->input('harga_satuan'),
                    'stok_barang'   => $request->input('stok_barang'),
                    'foto_barang'   => $request->hasFile('foto_barang') ? $foto_produk : $data->foto_barang,
                ]);

            return redirect()->route('list_produk')->with('success', 'Produk Berhasil DI Simpan');

        } else {

            return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Harap Gunakan Tombol Simpan Untuk Menyimpan Data');

        }
    }

    public function hapus_produk(Request $request, $id_barang) {

        $data = DB::table('tbl_barang')->where('id_barang', $id_barang);

        Storage::delete('public/produk/'.$data->first()->foto_barang);

        $data->delete();

        return redirect()->route('list_produk')->with('success', 'Produk Berhasil Di Hapus');

    }

    public function get_barang() {

        $id_barang = $_GET['id_barang'];

        $data = DB::table('tbl_barang')->where('id_barang', $id_barang)->first();

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
}
