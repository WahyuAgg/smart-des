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

            $table->string('kode_barang')->unique();
            $table->string('nama_barang');

            $table->foreignId('kategori_barang_id');
            $table->foreignId('lokasi_id');

            $table->unsignedInteger('jumlah')->default(0);

            $table->string('satuan', 30);

            $table->enum('kondisi', [
                'Baik',
                'Rusak Ringan',
                'Rusak Berat',
            ])->default('Baik');

            $table->date('tanggal_perolehan')->nullable();

            $table->text('keterangan')->nullable();

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
