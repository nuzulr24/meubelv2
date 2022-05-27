<?php

namespace App\Http\Controllers\Pengguna;

use Mail;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmailController extends Controller
{

    public function lupa_password(Request $request){

        try {

            $pesan = [
                'nama'  => 'Muhammad Iqbal',
                'pesan' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.'
            ];

            Mail::send('pengguna.email.lupa_password', $pesan, function($message) use ($request) {
                $message->subject('Konfirmasi Lupa Password');
                $message->from('no-reply@yoayostore.com', 'Yoayo Store');
                $message->to('dimas.pengguna@email.com');
            });


        } catch (Exception $err) {

            return response(['status' => 'false', 'errors' => $err->getMessage()]);

        }
    }

    public function verifikasi_register(){
        return false;
    }

    public function kontak(Request $request){

        $validasi = Validator::make($request->all(), [
            'nama'      => 'required|regex:/^[a-zA-Z\s]*$/|max:45',
            'email'     => 'required|email',
            'subject'   => 'required|string',
            'pesan'     => 'required|string'
        ]);

        if($validasi->fails()) {

            return back()->withErrors($validasi);

        }

        try {

            $pesan = [
                'nama'  => $request->input('nama'),
                'pesan' => $request->input('pesan')
            ];

            Mail::send('pengguna.email.hubungi', $pesan, function($message) use ($request) {
                $message->subject($request->input('subject'));
                $message->from($request->input('email'), $request->input('nama'));
                $message->to('cs.info@yoayostore.com');
            });

            return back()->with('success', 'Pesan Berhasil Di Kirim');

        } catch (Exception $err) {

            return response(['status' => 'false', 'errors' => $err->getMessage()]);

        }

    }
}
