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
        Schema::create('ref_profil_desa', function (Blueprint $table) {
            $table->id();

            $table->string('provinsi_code');

            $table->string('kabupaten_code');

            $table->string('kecamatan_code');

            $table->string('desa_code');

            $table->string('nama');
            $table->string('kode')->nullable()->unique();

            $table->string('kode_pos', 10)->nullable();

            $table->text('alamat')->nullable();

            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();

            $table->string('logo')->nullable();

            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->text('deskripsi')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_profil_desa');
    }
};
