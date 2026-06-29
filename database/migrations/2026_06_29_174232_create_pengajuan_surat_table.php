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
        Schema::create('pengajuan_surat', function (Blueprint $table) {
            $table->id();

            // Jenis surat yang diajukan
            $table->foreignId('jenis_surat_id');

            // Pemohon (penduduk)
            $table->foreignId('penduduk_id');

            // Nomor surat setelah disetujui
            $table->string('nomor_surat')->nullable();

            // Keperluan pengajuan surat
            $table->text('keperluan')->nullable();

            // draft | diajukan | diproses | selesai | ditolak
            $table->enum('status', [
                'draft',
                'diajukan',
                'diproses',
                'selesai',
                'ditolak'
            ])->default('draft');

            // Catatan dari petugas
            $table->text('catatan')->nullable();

            // Lokasi file hasil generate
            $table->string('file_hasil')->nullable();

            // Waktu-waktu penting
            $table->timestamp('tanggal_diajukan')->nullable();
            $table->timestamp('tanggal_diproses')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();

            // User/operator yang memproses (opsional)
            $table->foreignId('user_id')
                ->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_surat');
    }
};
