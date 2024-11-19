<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->foreignId('siswa_id')->index();
            $table->foreignId('arsip_id')->nullable();
            $table->foreignId('tahun_ajaran_id');
            $table->string('nama');
            $table->string('nis', 10);
            $table->string('kelas');
            $table->string('nama_tag');
            $table->integer('jumlah');
            $table->date('tgl_tagihan');
            $table->string('keterangan')->nullable();
            $table->enum('status', ['Baru', 'Mengangsur', 'Lunas']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tagihans');
    }
};