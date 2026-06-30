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
        Schema::create('inv_peminjaman', function (Blueprint $table) {
            $table->id();

            $table->string('nomor')->unique();

            $table->string('nama_peminjam');

            $table->date('tanggal_pinjam');

            $table->date('tanggal_rencana_kembali')->nullable();

            $table->enum('status', [
                'Dipinjam',
                'Sebagian Kembali',
                'Selesai',
            ])->default('Dipinjam');

            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_peminjaman');
    }
};
