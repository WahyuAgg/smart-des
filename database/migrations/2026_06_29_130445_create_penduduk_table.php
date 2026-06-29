<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penduduk', function (Blueprint $table) {
            $table->id();
            $table->string('nik');
            $table->string('nama_lengkap');
            $table->string('jenis_kelamin');
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir');
            $table->string('agama');
            $table->string('status_perkawinan');
            $table->string('kewarganegaraan');
            $table->string('golongan_darah');
            $table->string('no_hp');
            $table->string('email');
            $table->string('status_hidup');
            $table->date('tanggal_meninggal')->nullable();
            $table->foreignId('alamat_id');
            $table->foreignId('pendidikan_id');
            $table->foreignId('pekerjaan_id');
            $table->foreignId('kk_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penduduk');
    }
};
