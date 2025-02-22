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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tahun_ajaran_id')->nullable();
            $table->foreignId('tagihan_id')->index();
            $table->foreignId('wali_id')->index();
            $table->foreignId('siswa_id');
            $table->foreignId('arsip_id')->nullable();
            $table->dateTime('tgl_bayar');
            $table->string('status_konfirmasi')->nullable();
            $table->integer('jumlah_bayar');
            $table->string('bukti_bayar')->nullable();
            $table->string('metode_pembayaran', 50);
            $table->foreignId('user_id')->nullable()->index();
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
        Schema::dropIfExists('pembayarans');
    }
};