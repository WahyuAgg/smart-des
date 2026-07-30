<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ref_profil_desa', function (Blueprint $table) {
            $table->dropColumn([
                'provinsi_code',
                'kabupaten_code',
                'kecamatan_code',
                'desa_code',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('ref_profil_desa', function (Blueprint $table) {
            $table->string('provinsi_code');
            $table->string('kabupaten_code');
            $table->string('kecamatan_code');
            $table->string('desa_code');
        });
    }
};