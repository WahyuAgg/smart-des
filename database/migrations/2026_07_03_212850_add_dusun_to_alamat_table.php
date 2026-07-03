<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alamat', function (Blueprint $table) {
            // Menambahkan kolom dusun, nullable agar tidak error jika data lama kosong
            // after('desa') menempatkan kolom setelah kolom desa
            $table->string('dusun')->nullable()->after('desa');
        });
    }

    public function down(): void
    {
        Schema::table('alamat', function (Blueprint $table) {
            $table->dropColumn('dusun');
        });
    }
};