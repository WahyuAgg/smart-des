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
        Schema::create('jenis_surat_field', function (Blueprint $table) {
            $table->id();

            $table->foreignId('jenis_surat_id');

            $table->foreignId('master_field_surat_id');

            // Apakah field wajib diisi untuk jenis surat ini
            $table->boolean('wajib')->default(false);

            // Urutan tampil pada form
            $table->unsignedSmallInteger('urutan')->default(1);

            $table->timestamps();

            $table->unique([
                'jenis_surat_id',
                'master_field_surat_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_surat_field');
    }
};