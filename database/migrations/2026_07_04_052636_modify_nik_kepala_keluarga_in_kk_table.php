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
        Schema::table('kk', function (Blueprint $table) {
            // Mengubah kolom nik_kepala_keluarga menjadi nullable
            $table->string('nik_kepala_keluarga')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kk', function (Blueprint $table) {
            // Mengembalikan kolom menjadi not nullable (wajib)
            $table->string('nik_kepala_keluarga')->nullable(false)->change();
        });
    }
};