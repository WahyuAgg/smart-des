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

            // Data Utama (Wajib diisi)
            $table->string('nik')->unique();
            $table->string('nama_lengkap');
            $table->foreignId('kk_id'); // Relasi ke keluarga harus ada

            // Data Pelengkap (Boleh kosong/nullable)
            $table->string('jenis_kelamin')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('agama')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('status_perkawinan')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->string('golongan_darah')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->string('status_hidup')->default('Hidup'); // Default agar tidak null
            $table->date('tanggal_meninggal')->nullable();

            // Foreign Keys (Nullable jika penduduk belum memiliki data terkait)
            $table->foreignId('alamat_id')->nullable();
            $table->foreignId('pendidikan_id')->nullable();

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
