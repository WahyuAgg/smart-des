<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alamat', function (Blueprint $table) {
            $table->string('alamat_lengkap')->nullable()->change();
            $table->string('jalan')->nullable()->change();
            $table->string('rt')->nullable()->change();
            $table->string('rw')->nullable()->change();
            $table->string('desa')->nullable()->change();
            $table->string('kecamatan')->nullable()->change();
            $table->string('kabupaten')->nullable()->change();
            $table->string('provinsi')->nullable()->change();
            $table->string('kode_pos')->nullable()->change();
            $table->decimal('latitude', 10, 7)->nullable()->change();
            $table->decimal('longitude', 10, 7)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('alamat', function (Blueprint $table) {
            $table->string('alamat_lengkap')->nullable(false)->change();
            $table->string('jalan')->nullable(false)->change();
            $table->string('rt')->nullable(false)->change();
            $table->string('rw')->nullable(false)->change();
            $table->string('desa')->nullable(false)->change();
            $table->string('kecamatan')->nullable(false)->change();
            $table->string('kabupaten')->nullable(false)->change();
            $table->string('provinsi')->nullable(false)->change();
            $table->string('kode_pos')->nullable(false)->change();
            $table->decimal('latitude', 10, 7)->nullable(false)->change();
            $table->decimal('longitude', 10, 7)->nullable(false)->change();
        });
    }
};