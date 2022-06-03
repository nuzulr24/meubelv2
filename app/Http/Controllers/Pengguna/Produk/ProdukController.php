<?php

namespace App\Http\Controllers\Pengguna\Produk;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProdukController extends Controller
{

    public function index(Request $request) {

        $data = [];

        foreach (DB::table('tbl_kategori')->get() as $item) {
            $data[] = [
                'nama_kategori' => $item->nama_kategori,
                'jumlah_barang' => DB::table('tbl_barang')->where('id_kategori', $item->id_kategori)->count()
            ];
        }

        if($request->has('kategori')) {

            $nama_kategori = str_replace('-', ' ', ucwords($request->input('kategori'), '-'));

            $kategori = DB::table('tbl_kategori')->where('nama_kategori', $nama_kategori);

            if($request->has('search')) {

                $search = '%'.$request->input('search').'%';

                $data_produk = DB::table('tbl_barang')->where([
                    ['id_kategori', $kategori->exists() ? $kategori->first()->id_kategori : ''],
                    ['nama_barang', 'LIKE', $search]
                ]);

            } else {

                $data_produk = DB::table('tbl_barang')->where('id_kategori',
                    $kategori->exists() ? $kategori->first()->id_kategori : ''
                );

            }

            return view('pengguna.produk.produk', [
                'produk'        => $data_produk->simplePaginate(10),
                'kategori'      => $data,
                'data_filter'   => $nama_kategori,
                'jumlah_barang' => DB::table('tbl_barang')
            ]);

        } else {

            if($request->has('search')) {

                $search = '%'.$request->input('search').'%';

                return view('pengguna.produk.produk', [
                    'produk'        => DB::table('tbl_barang')->where('nama_barang', 'LIKE', $search)->simplePaginate(10),
                    'kategori'      => $data,
                    'jumlah_barang' => DB::table('tbl_barang')
                ]);

            } else {

                return view('pengguna.produk.produk', [
                    'produk'        => DB::table('tbl_barang')->simplePaginate(10),
                    'kategori'      => $data,
                    'jumlah_barang' => DB::table('tbl_barang')
                ]);

            }

        }

    }

    public function filter(){
        return false;
    }
}
