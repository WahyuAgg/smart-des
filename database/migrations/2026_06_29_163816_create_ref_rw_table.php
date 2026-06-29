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
        Schema::create('ref_rw', function (Blueprint $table) {
            $table->id();

            $table->foreignId('dusun_id');

            $table->string('nomor_rw', 3);
            $table->string('ketua_rw')->nullable();

            $table->timestamps();

            $table->unique([
                'dusun_id',
                'nomor_rw'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refrw');
    }
};
