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
        Schema::create('master_field_surat', function (Blueprint $table) {
            $table->id();

            // Key / placeholder pada template DOCX
            $table->string('nama')->unique();

            // Label yang ditampilkan pada form
            $table->string('label');

            // text, textarea, number, date, select, checkbox, dll.
            $table->string('tipe', 30)->default('text');

            // Jika tipe = select
            $table->json('opsi')->nullable();

            // Placeholder HTML
            $table->string('placeholder')->nullable();

            // Keterangan untuk admin
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_field_surat');
    }
};