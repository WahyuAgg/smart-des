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
        Schema::create('ref_rt', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rw_id');

            $table->string('nomor_rt', 3);
            $table->string('ketua_rt')->nullable();

            $table->timestamps();

            $table->unique([
                'rw_id',
                'nomor_rt'
            ]);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_rt');
    }
};
