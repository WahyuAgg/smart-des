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
        Schema::table('srt_master_field_surat', function (Blueprint $table) {
            $table->string('source')->nullable()->change();
            $table->string('source_field')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('srt_master_field_surat', function (Blueprint $table) {
            //
        });
    }
};
