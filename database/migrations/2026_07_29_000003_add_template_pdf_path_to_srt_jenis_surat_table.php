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
        Schema::table('srt_jenis_surat', function (Blueprint $table) {
            $table->string('template_pdf_path')
                ->nullable()
                ->after('template_path')
                ->comment('Lokasi file template surat dalam format PDF pada storage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('srt_jenis_surat', function (Blueprint $table) {
            $table->dropColumn('template_pdf_path');
        });
    }
};