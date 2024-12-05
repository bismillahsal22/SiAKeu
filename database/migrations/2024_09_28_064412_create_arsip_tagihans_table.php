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
            $table->string('status_siswa', 50);
            $table->string('nis', 10)->unique();
            $table->string('nama', 50);
            $table->string('kelas', 20);
            $table->foreignId('tahun_ajaran_id');
            $table->integer('jumlah_tag');
            $table->bigInteger('jumlah_bayar');
            $table->integer('kekurangan');
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