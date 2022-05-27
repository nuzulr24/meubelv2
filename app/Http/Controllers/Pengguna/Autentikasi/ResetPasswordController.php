<?php

namespace App\Http\Controllers\Pengguna\Autentikasi;

use Mail;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{
    public function index(Request $request) {

        if(!session()->has('email_pengguna')){

            return view('pengguna.autentikasi.lupa_password');

        } else {

            return back();

        }

    }

    public function reset_page(Request $request) {

        if($request->has('_token') && $request->has('_user') && !session()->has('email_pengguna')){

            $data = DB::table('tbl_lupa_password')->where('email', base64_decode($request->input('_user')));

            if(!$data->exists()) {

                return redirect()->route('login')->withErrors('Token sudah digunakan');

            }

            if(Carbon::parse(explode(' ', Carbon::now())[0])->lessThanOrEqualTo(Carbon::parse($data->first()->tanggal_dihapus))){

                if($data->exists() && Hash::check(decrypt($request->input('_token')), $data->first()->token)){

                    return view('pengguna.autentikasi.reset_password');

                } else {

                    return redirect()->route('lupa_password')->withErrors('Verifikasi bermasalah coba lagi');

                }

            } else {

                return redirect()->route('login')->withErrors('Access Token Kadaluarsa');

            }

        } else {

            return redirect()->route('lupa_password')->withErrors('Aktifitas bermasalah coba lagi');

        }

    }

    public function reset_password(Request $request) {

        if($request->has('user_token') && $request->has('_user') && !session()->has('email_pengguna')){

            $data = DB::table('tbl_lupa_password')->where('email', base64_decode($request->input('_user')));

            if(!$data->exists()) {

                return redirect()->route('login')->withErrors('Token sudah digunakan');

            }

            if($data->exists() && Hash::check(decrypt($request->input('user_token')), $data->first()->token)){

                $validasi = Validator::make($request->all(), [
                    'password'               => 'required|string|max:50|confirmed',
                    'password_confirmation'  => 'required|string|max:50'
                ]);

                if($validasi->fails()){

                    return back()->withErrors($validasi);

                }

                $token = DB::table('tbl_lupa_password')->where('email', base64_decode($request->input('_user')))->first();

                if(Carbon::parse(Carbon::now())->lessThanOrEqualTo(Carbon::parse($token->tanggal_dihapus))){

                    if(!Hash::check($request->input('password'), $data->first()->password)){

                        $data->update([
                            'password' => Hash::make($request->input('password'))
                        ]);

                        DB::table('tbl_lupa_password')->where('email', base64_decode($request->input('_user')))->delete();

                        return redirect()->route('login')->with('success', 'password berhasil di rubah');

                    } else {

                        return back()->withErrors('Harap gunakan password yang berbeda dari sebelumnya');

                    }

                } else {

                    return redirect()->route('login')->withErrors('Access Token Kadaluarsa');

                }

            } else {

                return redirect()->route('lupa_password')->withErrors('Verifikasi bermasalah coba lagi');

            }

        } else {

            return redirect()->route('lupa_password')->withErrors('Aktifitas bermasalah coba lagi');

        }

    }

    public function send_token(Request $request) {

        if(!session()->has('email_pengguna')) {

            $validasi = Validator::make($request->all(), [
                'email' => 'required|email|unique:tbl_lupa_password',
            ]);

            if($validasi->fails()){

                return back()->withErrors($validasi);

            }

            $data = DB::table('tbl_pengguna as pengguna')
                    ->join('tbl_detail_pengguna as detail', 'detail.id_pengguna', 'pengguna.id_pengguna')
                    ->select('pengguna.email', 'detail.nama_lengkap')
                    ->where('email', $request->input('email'));

            if ($data->exists()) {

                try {

                    $_token = random_bytes(16);

                    DB::table('tbl_lupa_password')->insert([
                        'email'           => $request->input('email'),
                        'token'           => Hash::make($_token),
                        'tanggal_dibuat'  => explode(' ', Carbon::now())[0],
                        'tanggal_dihapus' => explode(' ', Carbon::tomorrow())[0]
                    ]);

                    $pesan = [
                        'nama'  => $data->first()->nama_lengkap,
                        'pesan' => 'Silahkan klik pada alamat url dibawah untuk melanjutkan :<br>'.
                                    '<a href="'.route('reset_page').'?_user='.base64_encode($request->input('email')).'&_token='.encrypt($_token)
                                    .'">Klik Disini Untuk Melanjutkan</a><br><br>token akan kadaluarsa pada tanggal : '.explode(' ', Carbon::tomorrow())[0]
                    ];

                    Mail::send('pengguna.email.lupa_password', $pesan, function($message) use ($request) {
                        $message->subject('Lupa Password');
                        $message->from('no-reply@yoayostore.com', 'YoayoStore Customer Service');
                        $message->to($request->input('email'));
                    });

                    return redirect()->route('login')->with('success', 'Kode verifikasi telah dikirim melalui email.');

                } catch (Exception $err) {

                    return response(['status' => 'false', 'errors' => $err->getMessage()]);

                }

            } else {

                return back()->withErrors('Pengguna tidak ditemukan');

            }

        } else {

            return back();

        }

    }
}
