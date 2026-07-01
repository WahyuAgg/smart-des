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
        Schema::create('srt_master_field_surat', function (Blueprint $table) {
            $table->id();

            // Nama placeholder pada template DOCX
            // Contoh: nama_lengkap, nik, alamat, nomor_surat
            $table->string('nama')->unique();

            // Label yang ditampilkan di aplikasi
            $table->string('label');

            // Sumber data placeholder
            // input, penduduk, profil_desa, sistem, perangkat, jenis_surat
            $table->string('source', 30);

            // Nama field pada sumber data
            // Contoh:
            // penduduk.nama
            // penduduk.nik
            // profil_desa.alamat
            // NULL jika source = input
            $table->string('source_field')->nullable();

            // Digunakan jika source = input
            // text, textarea, number, email, date, select, dll.
            $table->string('tipe', 30)->default('text');

            // Opsi untuk select/radio
            $table->json('opsi')->nullable();

            // Petunjuk pengisian (khusus input)
            $table->string('placeholder')->nullable();

            // Keterangan untuk admin
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('srt_master_field_surat');
    }
};