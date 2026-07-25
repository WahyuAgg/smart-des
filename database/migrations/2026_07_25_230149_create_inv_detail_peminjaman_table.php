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
        Schema::create('inv_detail_peminjaman', function (Blueprint $table) {
            $table->id();
            
            // Foreign Keys
            $table->foreignId('peminjaman_id')->constrained('inv_peminjaman')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('inv_barang')->onDelete('restrict');
            
            // Kuantitas & Kondisi Pengembalian
            $table->integer('jumlah_pinjam')->default(0);
            $table->integer('jumlah_kembali_baik')->default(0);
            $table->integer('jumlah_kembali_rusak')->default(0);
            $table->integer('jumlah_hilang')->default(0);
            
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_detail_peminjaman');
    }
};