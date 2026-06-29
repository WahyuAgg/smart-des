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
        Schema::create('ref_perangkat_desa', function (Blueprint $table) {
            $table->id();

            $table->foreignId('jabatan_perangkat_id');

            $table->string('nama');

            $table->string('nip')->nullable();

            $table->string('telepon')->nullable();
            $table->string('email')->nullable();

            $table->string('foto')->nullable();
            $table->string('tanda_tangan')->nullable();

            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();

            $table->boolean('aktif')->default(true);

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_perangkat_desa');
    }
};
