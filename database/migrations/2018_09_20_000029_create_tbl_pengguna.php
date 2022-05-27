<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPengguna extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pengguna', function (Blueprint $table) {
            $table->string('id_pengguna', 20)->primary();
            $table->string('email', 30)->unique();
            $table->string('password', 50);
            $table->datetime('tanggal_bergabung')->useCurrent();
        });

        Schema::create('tbl_detail_pengguna', function (Blueprint $table) {
            $table->string('id_pengguna', 20);

            $table->unique('id_pengguna')
                ->references('id_pengguna')
                ->on('tbl_pengguna')
                ->onDelete('cascade')
                ->onUpdate('cascade');
                
            $table->string('nama_lengkap', 50)->nullable();
            $table->text('alamat_rumah')->nullable();
            $table->string('no_telepon', 18)->nullable();
            $table->string('foto')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_pengguna');
        Schema::dropIfExists('tbl_detail_pengguna');
    }
}
