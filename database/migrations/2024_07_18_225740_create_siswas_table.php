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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->integer('wali_id')->nullable()->index();
            $table->foreignId('tahun_ajaran_id')->nullable();
            $table->string('status_wali')->nullable();
            $table->string('status_siswa', 20)->nullable()->default('aktif'); // Default status
            $table->string('nama', 50);
            $table->string('nis', 10)->unique();
            $table->string('kelas');
            $table->boolean('naik_kelas')->default(false);
            $table->string('tempat_lahir', 50);
            $table->date('tgl_lahir');
            $table->enum('jk', ['Laki-Laki', 'Perempuan']);
            $table->string('nohp', 15)->nullable();
            $table->string('foto');
            $table->text('alamat');
            $table->string('ayah', 50);
            $table->string('ibu', 50);
            $table->foreignId('user_id');
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
        Schema::dropIfExists('siswas');
    }
};