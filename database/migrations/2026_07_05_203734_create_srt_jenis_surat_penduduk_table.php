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
        Schema::create('srt_jenis_surat_penduduk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_surat_id');
            $table->unsignedTinyInteger('urutan');
            $table->string('kode', 50);
            $table->string('label');
            $table->text('deskripsi')->nullable();
            $table->boolean('wajib')->default(true);
            $table->timestamps();

            $table->unique(['jenis_surat_id', 'urutan']);
            $table->unique(['jenis_surat_id', 'kode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('srt_jenis_surat_penduduk');
    }
};
