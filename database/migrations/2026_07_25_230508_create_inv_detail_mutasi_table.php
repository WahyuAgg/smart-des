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
        Schema::create('inv_detail_mutasi', function (Blueprint $table) {
            $table->id();
            
            // Foreign Keys
            $table->foreignId('mutasi_id')->constrained('inv_mutasi')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('inv_barang')->onDelete('restrict');
            
            // Jumlah perubahan kuantitas
            $table->integer('jumlah');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_detail_mutasi');
    }
};