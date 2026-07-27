<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * - Hapus konsep barang rusak: kolom jumlah_rusak & jumlah_tersedia di inv_barang
     * - jumlah_tersedia dihitung real-time: jumlah_total - jumlah_dipinjam
     * - Sederhanakan kolom pengembalian: jumlah_kembali_baik → jumlah_kembali, hapus jumlah_kembali_rusak
     */
    public function up(): void
    {
        Schema::table('inv_barang', function (Blueprint $table) {
            $table->dropColumn(['jumlah_tersedia', 'jumlah_rusak']);
        });

        Schema::table('inv_detail_peminjaman', function (Blueprint $table) {
            $table->renameColumn('jumlah_kembali_baik', 'jumlah_kembali');
            $table->dropColumn('jumlah_kembali_rusak');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inv_barang', function (Blueprint $table) {
            $table->integer('jumlah_tersedia')->default(0);
            $table->integer('jumlah_rusak')->default(0);
        });

        Schema::table('inv_detail_peminjaman', function (Blueprint $table) {
            $table->renameColumn('jumlah_kembali', 'jumlah_kembali_baik');
            $table->integer('jumlah_kembali_rusak')->default(0);
        });
    }
};