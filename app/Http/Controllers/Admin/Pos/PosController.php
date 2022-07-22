<?php

namespace App\Http\Controllers\Admin\Pos;

use DateTime;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class PosController extends Controller
{
    public function index(Request $request) {

        if($request->session()->exists('email_admin')) {

            $data = DB::table('tbl_barang')->get();

            return view('admin.pos.index', [
                'data_barang' => $data
            ]);

        } else {

            return redirect()->route('login_admin');

        }
    }

    public function checkout(Request $request) {

        $validasi = Validator::make($request->all(), [
            'id_produk' => 'required',
            'tipe_barang' => 'required',
            'jumlah' => 'required|integer'
        ]);

        if ($validasi->fails()) {

            return back()->withErrors($validasi);

        }

        $id_pesanan  = $this->set_id_pesanan();

        if(DB::table('tbl_transaction')->where('id_pesanan', $id_pesanan)->exists() == false) {

            $data = DB::table('tbl_barang')->where('id_barang', $request->input('id_produk'))->value('harga_satuan');

            $save_pesanan = DB::table('tbl_transaction')->insert([
                'id_pesanan' => $id_pesanan,
                'id_pengguna' => session('id_admin'),
                'id_product' => $request->input('id_produk'),
                'type' => $request->input('tipe_barang'),
                'qty' => $request->input('jumlah'),
                'total_bayar' => $data * $request->input('jumlah')
            ]);

            if($save_pesanan == true)
            {
                return redirect()->route('list_pos')->with('success', 'Pesanan Berhasil ditambahkan');
            } else {
                return back()->withErrors('Terjadi kesalahan pada menyimpan data');
            }
        } else {

            return back()->withErrors('Terdapat data tidak dapat di gunakan karna telah tersedia');

        }
    }

    protected function set_id_pesanan()
    {

        $data = DB::table('tbl_transaction')->max('id_pesanan');

        if (!empty($data)) {

            $no_urut = substr($data, 9, 3) + 1;

            return 'PSN' . (new Datetime)->format('ymd') . $no_urut;
        } else {
            return 'PSN' . (new Datetime)->format('ymd') . '1';
        }
    }
}
