<?php

namespace App\Http\Controllers\Pengguna\Pesanan;

use DateTime;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PembayaranController extends Controller
{
    public function index(Request $request){

        $data = DB::table('tbl_pembayaran as pembayaran')
            ->join('tbl_pesanan as pesanan', 'pesanan.id_pesanan', 'pembayaran.id_pesanan')
            ->select('pembayaran.*', 'pesanan.total_bayar')
            ->where([
                ['pembayaran.id_pengguna', session('id_pengguna')],
                ['pembayaran.selesai', '0'], ['pembayaran.foto_bukti', '<>', 'NULL']
            ])->get();

        return view('pengguna.pesanan.pembayaran', ['data_pembayaran' => $data]);

    }

    public function upload_bukti(Request $request, $id_pesanan) {

        if (session()->has('email_pengguna')) {

            $data = DB::table('tbl_pembayaran')->where('id_pesanan', $id_pesanan);

            if(Carbon::parse(explode(' ', Carbon::now())[0])->gt(Carbon::parse($data->first()->batas_pembayaran))) {

                return back()->withErrors('Pesanan "'.$id_pesanan.'" Sudah Melampaui Batas Waktu');

            }

            if($data->first()->foto_bukti != NULL) {

                return redirect()->route('pesanan');

            }

            return view('pengguna.pesanan.upload_bukti', ['id_pesanan' => $id_pesanan]);

        } else {

            return redirect()->route('login')->withErrors('harus login terlebih dahulu');

        }

    }

    public function save_bukti(Request $request, $id_pesanan) {

        if(session()->has('email_pengguna') && $request->has('simpan')) {

            $validasi = Validator::make($request->all(), [
                'bukti_pembayaran'  => 'required|mimes:jpg,jpeg,png'
            ]);

            if($validasi->fails()) {

                return back()->withErrors($validasi);

            }

            $data = DB::table('tbl_pembayaran')->where('id_pesanan', $id_pesanan);

            if(Carbon::parse(explode(' ', Carbon::now())[0])->gt(Carbon::parse($data->first()->batas_pembayaran))) {

                return back()->withErrors('Sudah Melampaui Batas Waktu');

            }

            $data_barang = DB::table('tbl_detail_pesanan')->select('id_barang')
                        ->where('id_pesanan', $id_pesanan)->get();

            foreach($data_barang as $item){

                $stok1 = DB::table('tbl_barang')->where('id_barang', $item->id_barang)->first();

                if($stok1->stok_barang <= 0){

                    return back()->withErrors('stok "'.$stok1->nama_barang.'" kosong / telah habis.');

                }
            }

            if($data->exists() && $data->first()->foto_bukti == NULL) {

                $extension = $request->file('bukti_pembayaran')->getClientOriginalExtension();

                $foto_bukti = Storage::putFileAs(
                    'public/pembayaran/',
                    $request->file('bukti_pembayaran'), $id_pesanan.'.'.$extension
                );

                DB::table('tbl_pembayaran')->where('id_pesanan', $id_pesanan)->update([
                    'foto_bukti'        =>  $id_pesanan.'.'.$extension,
                    'tanggal_upload'    =>  Carbon::now(),
                ]);

                $data_barang = DB::table('tbl_detail_pesanan')->select('id_barang', 'jumlah_beli')
                        ->where('id_pesanan', $id_pesanan)->get();

                foreach($data_barang as $item){

                    $detail = DB::table('tbl_barang')->where('id_barang', $item->id_barang);

                    $stok_barang = $detail->first()->stok_barang - $item->jumlah_beli;

                    $detail->update(['stok_barang' => $stok_barang]);

                }

                return redirect()->route('pesanan')->with('success', 'Bukti pembayaran berhasil di upload, menunggu pembayaran diverifikasi.');

            } else {

                return back()->withErrors('Terjadi Kesalahan Saat Menyimpan Foto');

            }

        } else {

            return redirect()->route('login')->withErrors('harus login terlebih dahulu');

        }

    }
}
