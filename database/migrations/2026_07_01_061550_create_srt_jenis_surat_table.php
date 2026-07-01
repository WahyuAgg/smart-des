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
        Schema::create('srt_jenis_surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_surat_id');
            $table->string('kode_jenis_surat')->unique();
            $table->string('nama_jenis_surat');
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('srt_jenis_surat');
    }
};
