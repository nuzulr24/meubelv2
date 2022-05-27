<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblLupaPassword extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_lupa_password', function (Blueprint $table) {
            $table->string('email', 30)->unique();
            $table->string('token', 50);
            $table->date('tanggal_dibuat')->useCurrent();
            $table->date('tanggal_dihapus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_lupa_password');
    }
}
