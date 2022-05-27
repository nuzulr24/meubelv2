<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPembayaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pembayaran', function (Blueprint $table) {
            $table->string('id_pesanan', 20);

            $table->unique('id_pesanan')
                ->references('id_pesanan')
                ->on('tbl_pesanan')
                ->onUpdate('cascade');

            $table->string('foto_bukti', 30);
            $table->boolean('status_pembayaran');
            $table->date('batas_pembayaran');
            $table->datetime('tanggal_upload')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_pembayaran');
    }
}
