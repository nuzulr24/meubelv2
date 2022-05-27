<?php

namespace App\Http\Controllers\Admin\Pengaturan;

use DateTime;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    //

    public function index(Request $request)
    {
        $table = 'tbl_website';
        if($request->session()->exists('email_admin') && session('superadmin') == true)
        {
            return view('admin.pengaturan.home', [
                'detail' => [
                    'title' => DB::table($table)->where('id', 1)->value('value'),
                    'favicon' => DB::table($table)->where('id', 2)->value('value'),
                    'meta_description' => DB::table($table)->where('id', 3)->value('value'),
                    'meta_keywords' => DB::table($table)->where('id', 4)->value('value'),
                    'address' => DB::table($table)->where('id', 9)->value('value'),
                    'phone' => DB::table($table)->where('id', 10)->value('value'),
                    'email' => DB::table($table)->where('id', 11)->value('value'),
                    'facebook' => DB::table($table)->where('id', 12)->value('value'),
                    'logo' => DB::table($table)->where('id', 13)->value('value'),
                    'short_description' => DB::table($table)->where('id', 14)->value('value'),
                    'about' => DB::table($table)->where('id', 15)->value('value'),
                    'kota' => DB::table($table)->where('id', 18)->value('value'),
                    'biaya_cod' => DB::table($table)->where('id', 17)->value('value'),
                    'jam_kerja' => DB::table($table)->where('id', 16)->value('value'),
                    'list_kota' => DB::table('tbl_kabupaten')->get(),
                ],
                'payment_options' => [
                    'status_transfer' => DB::table($table)->where('id', 20)->value('value'),
                    'status_midtrans' => DB::table($table)->where('id', 21)->value('value'),
                    'midtrans_server' => DB::table($table)->where('id', 22)->value('value'),
                    'midtrans_client' => DB::table($table)->where('id', 23)->value('value'),
                    'midtrans_snap' => DB::table($table)->where('id', 24)->value('value'),
                    'list_rekening' => DB::table('tbl_rekening')->get(),
                    'list_bank' => DB::table('tbl_rekeningbank')->get()
                ]
            ]);
        } else {
            return redirect()->route('login_admin');
        }
    }

    public function edit_pengaturan(Request $request)
    {
        $table = 'tbl_website';
        switch($request->input('tipe'))
        {
            case 1;

            $validasi = Validator::make($request->all(), [
                'logo_image'       => 'mimes:jpg,jpeg,png|max:4064',
                'favicon_image'       => 'mimes:jpg,jpeg,png|max:4064'
            ]);

            if ($validasi->fails()) {
                return back()->withErrors($validasi);
            }

            if($request->has('logo_image') === false || $request->has('favicon_image') === false)
            {

                $logo = DB::table($table)->where('id', 13)->value('value');
                $favicon = DB::table($table)->where('id', 2)->value('value');

                DB::table('tbl_website')
                ->where('id', 1)
                ->update(['value' => $request->input('title')]);
                DB::table('tbl_website')
                ->where('id', 2)
                ->update(['value' => $favicon]);
                DB::table('tbl_website')
                ->where('id', 3)
                ->update(['value' => $request->input('meta_description')]);
                DB::table('tbl_website')
                ->where('id', 4)
                ->update(['value' => $request->input('meta_keywords')]);
                DB::table('tbl_website')
                ->where('id', 9)
                ->update(['value' => $request->input('address')]);
                DB::table('tbl_website')
                ->where('id', 10)
                ->update(['value' => $request->input('phone')]);
                DB::table('tbl_website')
                ->where('id', 11)
                ->update(['value' => $request->input('email')]);
                DB::table('tbl_website')
                ->where('id', 12)
                ->update(['value' => $request->input('facebook')]);
                DB::table('tbl_website')
                ->where('id', 13)
                ->update(['value' => $logo]);
                DB::table('tbl_website')
                ->where('id', 14)
                ->update(['value' => $request->input('short_description')]);
                DB::table('tbl_website')
                ->where('id', 15)
                ->update(['value' => $request->input('about')]);
                DB::table('tbl_website')
                ->where('id', 18)
                ->update(['value' => $request->input('kota')]);
                DB::table('tbl_website')
                ->where('id', 16)
                ->update(['value' => $request->input('jam_kerja')]);

                
                return redirect()->route('pengaturan')->with('success', 'Pengaturan Umum Berhasil Diperbarui');

            } else {

                $extension_first = $request->file('logo_image')->getClientOriginalExtension();
                $extension_last = $request->file('favicon_image')->getClientOriginalExtension();

                $save_logo = Storage::putFileAs(
                    'public/images/',
                    $request->file('logo_image'), $request->file('logo_image')->getClientOriginalName()
                );

                $save_favicon = Storage::putFileAs(
                    'public/images/',
                    $request->file('favicon_image'), $request->file('favicon_image')->getClientOriginalName()
                );

                $file_favicon = $request->file('favicon_image')->getClientOriginalName();
                $file_logo = $request->file('logo_image')->getClientOriginalName();

                // echo $request->file('favicon_image')->getClientOriginalName() . ' - ' . $request->file('logo_image')->getClientOriginalName();

                DB::table('tbl_website')
                ->where('id', 1)
                ->update(['value' => $request->input('title')]);
                DB::table('tbl_website')
                ->where('id', 2)
                ->update(['value' => $file_favicon]);
                DB::table('tbl_website')
                ->where('id', 3)
                ->update(['value' => $request->input('meta_description')]);
                DB::table('tbl_website')
                ->where('id', 4)
                ->update(['value' => $request->input('meta_keywords')]);
                DB::table('tbl_website')
                ->where('id', 9)
                ->update(['value' => $request->input('address')]);
                DB::table('tbl_website')
                ->where('id', 10)
                ->update(['value' => $request->input('phone')]);
                DB::table('tbl_website')
                ->where('id', 11)
                ->update(['value' => $request->input('email')]);
                DB::table('tbl_website')
                ->where('id', 12)
                ->update(['value' => $request->input('facebook')]);
                DB::table('tbl_website')
                ->where('id', 13)
                ->update(['value' => $file_logo]);
                DB::table('tbl_website')
                ->where('id', 14)
                ->update(['value' => $request->input('short_description')]);
                DB::table('tbl_website')
                ->where('id', 15)
                ->update(['value' => $request->input('about')]);
                DB::table('tbl_website')
                ->where('id', 18)
                ->update(['value' => $request->input('kota')]);
                DB::table('tbl_website')
                ->where('id', 16)
                ->update(['value' => $request->input('jam_kerja')]);

                return redirect()->route('pengaturan')->with('success', 'Pengaturan Umum [2] Berhasil Diperbarui');
            }

            break;

            case 2;

            $validasi = Validator::make($request->all(), [
                'midtrans_server' => 'required',
                'midtrans_client' => 'required',
                'midtrans_snap' => 'required',
            ]);

            if ($validasi->fails()) {

                return back()->withErrors($validasi);

            }
            
            $update_server = DB::table('tbl_website')->where('id', 22)
                    ->update(['value' => $request->input('midtrans_server')]);
            $update_client = DB::table('tbl_website')->where('id', 23)
                    ->update(['value' => $request->input('midtrans_client')]);
            $update_snap = DB::table('tbl_website')->where('id', 24)
                    ->update(['value' => $request->input('midtrans_snap')]);

            // dd($update_server);
            
            if($update_server == 0 && $update_client == 0 && $update_snap == 0) {
                return redirect()->route('pengaturan')->with('success', 'Konfigurasi API Midtrans Berhasil Di Rubah');
            } else {
                return redirect()->route('pengaturan')->withErrors('Konfigurasi API Midtrans tidak dapat diperbarui');
            }

            break;

            case 3;

            $validasi = Validator::make($request->all(), [
                'biaya_kurir' => 'integer'
            ]);

            if ($validasi->fails()) {

                return back()->withErrors($validasi);

            }
            
            $update = DB::table('tbl_website')->where('id', 17)
                    ->update(['value' => $request->input('biaya_kurir')]);

            if($update == 0) {
                return redirect()->route('pengaturan')->with('success', 'Biaya COD Berhasil Di Rubah');
            } else {
                return redirect()->route('pengaturan')->withErrors('Biaya COD tidak dapat diperbarui');
            }

            break;

            case 4;
                $validasi = Validator::make($request->all(), [
                    'atas_nama' => 'required',
                    'nomer_rekening' => 'required|integer',
                    'id_bank' => 'required'
                ]);
        
                if ($validasi->fails()) {
        
                    return back()->withErrors($validasi);
        
                }
        
                if(DB::table('tbl_rekening')->where('nomer_rekening', $request->input('nomer_rekening'))->exists() == false) {
        
                    DB::table('tbl_rekening')->insert([
                        'atas_nama' => $request->input('atas_nama'),
                        'nomer_rekening'  => $request->input('nomer_rekening'),
                        'id_bank'       => $request->input('id_bank'),
                        'is_active' => 1
                    ]);
        
                    return redirect()->route('pengaturan')->with('success', 'Pengaturan Umum Berhasil Diperbarui');
                    
                } else {
                    return back()->withErrors('Rekening tidak dapat ditambahkan karena telah ada');
                }
            break;
        }
    }

    public function edit_rekening(Request $request, $id_rekening)
    {
        if($request->session()->exists('email_admin') && session('superadmin') == true)
        {
            if($request->has('simpan'))
            {
                $validasi = Validator::make($request->all(), [
                    'atas_nama' => 'required',
                    'nomer_rekening' => 'required|integer',
                    'id_bank' => 'required|integer',
                    'is_active' => 'required|integer',
                ]);
    
                if ($validasi->fails()) {
    
                    return back()->withErrors($validasi);
    
                }
                
                $update = DB::table('tbl_rekening')->where('id', $id_rekening)
                        ->update([
                            'is_active' => $request->input('is_active'),
                            'atas_nama' => $request->input('atas_nama'),
                            'nomer_rekening' => $request->input('nomer_rekening'),
                            'id_bank' => $request->input('id_bank'),
                        ]);
    
                // dd($update_server);
                
                if($update == 0) {
                    return redirect()->route('pengaturan')->with('success', 'Data rekening Berhasil Di Rubah');
                } else {
                    return redirect()->route('pengaturan')->withErrors('Data rekening tidak dapat diperbarui');
                }
            } else {
                return view('admin.pengaturan.edit_rekening', [
                    'detail' => DB::table('tbl_rekening')->where('id', $id_rekening)->get()[0],
                    'rekening' => DB::table('tbl_rekeningbank')->get()
                ]);
            }
        } else {
            return redirect()->route('login_admin');
        }
    }

}
