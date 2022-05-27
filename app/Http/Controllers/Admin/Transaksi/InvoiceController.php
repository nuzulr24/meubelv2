<?php

namespace App\Http\Controllers\Admin\Transaksi;

use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    public function save_invoice($id_pesanan, $id_pengguna) {

        if(session()->has('email_admin')) {

            $data = DB::table('tbl_invoice')->insert([
                'id_invoice'    => $this->set_id_invoice(),
                'id_pesanan'    => $id_pesanan,
                'id_pengguna'   => $id_pengguna
            ]);

        } else {

            return redirect()->route('login_admin')->with('fail', 'Harap Login Terlebih Dahulu');

        }

    }

    public function delete_invoice($id_invoice) {

        if(session()->has('email_admin')) {

            $data = DB::table('tbl_invoice')->where([
                'id_invoice'    => $id_invoice,
            ])->delete();

        } else {

            return redirect()->route('login_admin')->with('fail', 'Harap Login Terlebih Dahulu');

        }

    }

    protected function set_id_invoice() {

        $data = DB::table('tbl_invoice')->max('id_invoice');

        if(!empty($data)) {

            $no_urut = substr($data, 9, 3) + 1;

            return 'INV'.(new Datetime)->format('ymd').$no_urut;
        } else {
            return 'INV'.(new Datetime)->format('ymd').'1';
        }
    }
}
