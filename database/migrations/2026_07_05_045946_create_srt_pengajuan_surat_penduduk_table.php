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
        Schema::create('srt_pengajuan_surat_penduduk', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('pengajuan_surat_id');
            $table->unsignedBigInteger('penduduk_id');

            $table->unsignedTinyInteger('urutan');

            $table->timestamps();

            $table->unique([
                'pengajuan_surat_id',
                'urutan',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('srt_pengajuan_surat_penduduk');
    }
};
