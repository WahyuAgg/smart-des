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
        Schema::create('inv_mutasi', function (Blueprint $table) {
            $table->id();
            
            // Foreign Key ke Peminjaman (Nullable)
            $table->foreignId('peminjaman_id')->nullable()->constrained('inv_peminjaman')->onDelete('set null');
            
            $table->string('nomor', 50)->unique();
            $table->enum('jenis', [
                'PENGADAAN', 
                'PINJAM', 
                'KEMBALI', 
                'HILANG', 
                'RUSAK', 
                'OPNAME', 
                'HAPUS'
            ]);
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_mutasi');
    }
};