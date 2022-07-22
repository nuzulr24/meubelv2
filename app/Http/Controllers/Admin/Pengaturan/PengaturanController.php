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
                    'meta_description' => DB::table($table)->where('id', 3)->value('value'),
                    'meta_keywords' => DB::table($table)->where('id', 4)->value('value'),
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
                'title'       => 'required'
            ]);

            if ($validasi->fails()) {
                return back()->withErrors($validasi);
            }

            $logo = DB::table($table)->where('id', 13)->value('value');
            $favicon = DB::table($table)->where('id', 2)->value('value');

            DB::table('tbl_website')
            ->where('id', 1)
            ->update(['value' => $request->input('title')]);
            DB::table('tbl_website')
            ->where('id', 3)
            ->update(['value' => $request->input('meta_description')]);
            DB::table('tbl_website')
            ->where('id', 4)
            ->update(['value' => $request->input('meta_keywords')]);
            
            return redirect()->route('pengaturan')->with('success', 'Pengaturan Umum Berhasil Diperbarui');

            break;
        }
    }
}
