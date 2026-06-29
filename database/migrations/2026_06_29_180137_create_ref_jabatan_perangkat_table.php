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
        Schema::create('ref_jabatan_perangkat', function (Blueprint $table) {
            $table->id();

            // Kode unik jabatan
            $table->string('kode', 20)->unique();

            // Nama jabatan
            $table->string('nama', 100);

            // Keterangan tambahan
            $table->text('deskripsi')->nullable();

            // Urutan tampilan
            $table->unsignedSmallInteger('urutan')->default(0);

            // Digunakan pada aplikasi
            $table->boolean('aktif')->default(true);

            // Berhak menandatangani surat
            $table->boolean('dapat_menandatangani')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_jabatan_perangkat');
    }
};
