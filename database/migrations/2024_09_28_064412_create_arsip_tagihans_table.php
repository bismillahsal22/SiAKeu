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
        Schema::create('arsip_tagihans', function (Blueprint $table) {
            $table->id();
            $table->string('status_siswa');
            $table->string('nis', 10)->unique();
            $table->string('nama', 255);
            $table->string('kelas');
            $table->foreignId('tahun_ajaran_id');
            $table->integer('jumlah_tag');
            $table->bigInteger('jumlah_bayar');
            $table->integer('kekurangan');
            $table->text('riwayat_tag')->nullable();
            $table->text('riwayat_bayar')->nullable();
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
        Schema::dropIfExists('arsip_tagihans');
    }
};