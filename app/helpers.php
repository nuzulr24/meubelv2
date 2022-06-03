<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

function getShortName($string = null) {
    return array_reduce(
        explode(' ', $string),
        function ($initials, $word) {
            return sprintf('%s%s', $initials, substr($word, 0, 1));
        },
        ''
    );
}

function formatHandphone($nomorhp) {
    //Terlebih dahulu kita trim dl
    $nomorhp = trim($nomorhp);
   //bersihkan dari karakter yang tidak perlu
    $nomorhp = strip_tags($nomorhp);     
   // Berishkan dari spasi
   $nomorhp= str_replace(" ","",$nomorhp);
   // bersihkan dari bentuk seperti  (022) 66677788
    $nomorhp= str_replace("(","",$nomorhp);
   // bersihkan dari format yang ada titik seperti 0811.222.333.4
    $nomorhp= str_replace(".","",$nomorhp); 

    //cek apakah mengandung karakter + dan 0-9
    if(!preg_match('/[^+0-9]/',trim($nomorhp))){
        // cek apakah no hp karakter 1-3 adalah +62
        if(substr(trim($nomorhp), 0, 3)=='+62'){
            $nomorhp= trim($nomorhp);
        }
        // cek apakah no hp karakter 1 adalah 0
       elseif(substr($nomorhp, 0, 1)=='0'){
            $nomorhp= '+62'.substr($nomorhp, 1);
        }
    }
    return $nomorhp;
}

function getContact()
{
    return [
        'title' => DB::table('tbl_website')->where('id', 1)->value('value'),
        'address' => DB::table('tbl_website')->where('id', 9)->value('value'),
        'phone' =>  formatHandphone(DB::table('tbl_website')->where('id', 10)->value('value')),
        'email' =>  DB::table('tbl_website')->where('id', 11)->value('value'),
        'short' =>  DB::table('tbl_website')->where('id', 14)->value('value'),
        'background' =>  DB::table('tbl_website')->where('id', 25)->value('value'),
    ];
}

function getSetting()
{
    return [
        'status_transfer' => DB::table('tbl_website')->where('id', 20)->value('value'),
        'status_midtrans' => DB::table('tbl_website')->where('id', 21)->value('value'),
        'midtrans_server' =>  DB::table('tbl_website')->where('id', 22)->value('value'),
        'midtrans_client' =>  DB::table('tbl_website')->where('id', 23)->value('value'),
        'midtrans_snap' =>  DB::table('tbl_website')->where('id', 24)->value('value'),
    ];
}