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

            $table->foreignId('peminjaman_id');

            $table->foreignId('barang_id');

            $table->unsignedInteger('jumlah_pinjam');

            $table->unsignedInteger('jumlah_kembali')->default(0);

            $table->unsignedInteger('jumlah_hilang')->default(0);

            $table->unsignedInteger('jumlah_rusak')->default(0);

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
