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
        Schema::create('bank_sekolahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_id');
            $table->foreignId('user_id');
            $table->string('kode', 10);
            $table->string('nama_bank', 50);
            $table->string('nama_rekening', 50);
            $table->string('nomor_rekening', 10);
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
        Schema::dropIfExists('bank_sekolahs');
    }
};