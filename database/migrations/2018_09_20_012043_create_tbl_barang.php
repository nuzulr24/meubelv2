<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblBarang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_barang', function (Blueprint $table) {
            $table->string('id_barang', 20)->primary();
            $table->string('nama_barang', 20);
            $table->string('id_kategori', 20);

            $table->index('id_kategori')
                ->references('id_kategori')
                ->on('tbl_kategori')
                ->onUpdate('cascade');
                
            $table->double('berat_barang');
            $table->integer('harga_satuan');
            $table->integer('stok_barang');
            $table->datetime('tanggal_masuk')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_barang');
    }
}
