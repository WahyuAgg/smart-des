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
        Schema::create('field_surat', function (Blueprint $table) {
            $table->id();

            $table->foreignId('jenis_surat_id');

            // Nama placeholder pada template DOCX
            $table->string('nama');

            // Label yang ditampilkan pada form
            $table->string('label');

            // text, textarea, number, date, select, checkbox, dll.
            $table->string('tipe', 30)->default('text');

            // Jika tipe = select
            $table->json('opsi')->nullable();

            $table->boolean('wajib')->default(false);

            // Urutan field pada form
            $table->unsignedSmallInteger('urutan')->default(1);

            $table->string('placeholder')->nullable();

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->unique([
                'jenis_surat_id',
                'nama'
            ]);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_surat');
    }
};
