<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPesanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pesanan', function (Blueprint $table) {
            $table->string('id_pesanan', 20)->primary();
            $table->string('id_pengguna', 20);

            $table->index('id_pengguna')
                ->references('id_pengguna')
                ->on('tbl_pengguna')
                ->onUpdate('cascade');

            $table->string('nama_penerima', 40);
            $table->text('alamat_tujuan');
            $table->string('no_telepon', 18);
            $table->double('total_bayar');
            $table->string('no_resi', 30)->nullable();
            $table->tinyInteger('status_pesanan');
            $table->boolean('dibatalkan');
            $table->datetime('tanggal_dikirim')->nullable();
        });

        Schema::create('tbl_detail_pesanan', function (Blueprint $table) {
            $table->string('id_pesanan', 20);
            $table->string('id_barang', 20);

            $table->index('id_barang')
                ->references('id_barang')
                ->on('tbl_barang')
                ->onUpdate('cascade');

            $table->integer('jumlah_beli');
            $table->double('subtotal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_pesanan');
        Schema::dropIfExists('tbl_detail_pesanan');
    }
}
