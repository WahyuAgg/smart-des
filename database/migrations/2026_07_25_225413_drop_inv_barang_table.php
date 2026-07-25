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
        Schema::dropIfExists('inv_detail_peminjaman');
        Schema::dropIfExists('inv_peminjaman');
        Schema::dropIfExists('inv_barang');



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
