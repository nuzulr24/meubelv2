<?php

namespace App\Http\Controllers\Pengguna;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BerandaController extends Controller
{

    public function index(Request $request) {

        $data = NULL;

        if($request->session()->exists('id_pengguna')) {

            $data = DB::table('tbl_detail_pengguna')->where('id_pengguna', session('id_pengguna'))->first();

        }

        return view('pengguna.beranda', ['data_pengguna' => (!is_null($data) ? $data : null)]);
    }
}
