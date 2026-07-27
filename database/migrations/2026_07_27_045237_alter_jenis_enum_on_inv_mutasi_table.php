<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inv_mutasi', function (Blueprint $table) {
            $table->enum('jenis', [
                'PENGADAAN',
                'PINJAM',
                'KEMBALI',
                'HILANG',
                'KETEMU',
                'OPNAME',
                'HAPUS',
            ])->change();
        });
    }

    public function down(): void
    {
        Schema::table('inv_mutasi', function (Blueprint $table) {
            $table->enum('jenis', [
                'PENGADAAN',
                'PINJAM',
                'KEMBALI',
                'HILANG',
                'OPNAME',
                'HAPUS',
            ])->change();
        });
    }
};