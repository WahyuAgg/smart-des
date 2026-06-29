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
            $table->string('kewarnagaran');
            $table->string('golongan_darah');
            $table->string('no_hp');
            $table->string('email');
            $table->string('status_hidup');
            $table->string('tanggal_meninggal')->nullable();
            $table->foreignId('alamat_id')->constrained('alamat')->onDelete('cascade');
            $table->foreignId('pendidikan_id')->constrained('pendidikan')->onDelete('cascade');
            $table->foreignId('pekerjaan_id')->constrained('pekerjaan')->onDelete('cascade');
            $table->foreignId('kk_id')->constrained('kk')->onDelete('cascade');
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
