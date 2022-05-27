<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormatRupiah extends Controller
{
    public static function create($jumlah) {

        return 'Rp '.number_format($jumlah, 0, ',' , '.');

    }
}
