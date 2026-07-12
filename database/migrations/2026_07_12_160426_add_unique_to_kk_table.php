<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kk', function (Blueprint $table) {
            $table->string('no_kk')->unique()->change();
            $table->string('nik_kepala_keluarga')->nullable()->unique()->change();
        });
    }

    public function down(): void
    {
        Schema::table('kk', function (Blueprint $table) {
            $table->dropUnique('kk_no_kk_unique');
            $table->dropUnique('kk_nik_kepala_keluarga_unique');
        });
    }
};