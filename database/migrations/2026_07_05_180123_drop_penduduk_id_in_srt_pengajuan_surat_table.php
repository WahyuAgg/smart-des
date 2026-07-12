<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('srt_pengajuan_surat', function (Blueprint $table) {
            // Penting: Hapus foreign key constraint terlebih dahulu sebelum drop kolom
            // Sesuaikan nama constraint jika Anda tidak menggunakan penamaan standar Laravel
            // $table->dropForeign(['penduduk_id']);
            
            // Hapus kolomnya
            $table->dropColumn('penduduk_id');
        });
    }

    public function down(): void
    {
        Schema::table('srt_pengajuan_surat', function (Blueprint $table) {
            // Tambahkan kembali kolom jika ingin melakukan rollback
            $table->foreignId('penduduk_id')->after('jenis_surat_id');
        });
    }
};