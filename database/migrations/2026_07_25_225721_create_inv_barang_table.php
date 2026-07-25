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
Schema::create('inv_barang', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang', 50)->unique();
            $table->string('nama_barang', 150);
            
            // Foreign Keys
            $table->foreignId('kategori_id')->constrained('inv_kategori_barang')->onDelete('restrict');
            $table->foreignId('lokasi_id')->constrained('inv_lokasi')->onDelete('restrict');
            
            $table->string('satuan', 50);
            $table->date('tanggal_perolehan')->nullable();
            $table->text('keterangan')->nullable();
            
            // Kolom Agregat Stok
            $table->integer('jumlah_total')->default(0);
            $table->integer('jumlah_tersedia')->default(0);
            $table->integer('jumlah_rusak')->default(0);
            $table->integer('jumlah_dipinjam')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_barang');
    }
};
