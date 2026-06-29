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
        Schema::create('value_field_surat', function (Blueprint $table) {
            $table->id();

            $table->foreignId('permohonan_surat_id');

            $table->foreignId('field_surat_id');

            $table->longText('value')->nullable();

            $table->timestamps();

            $table->unique([
                'permohonan_surat_id',
                'field_surat_id'
            ]);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('value_field_surat');
    }
};
