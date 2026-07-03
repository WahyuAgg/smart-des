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

            $table->enum('input_mode', [
                'auto',
                'manual',
                'auto_editable',
            ])->default('manual')
              ->after('source_field');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('srt_master_field_surat', function (Blueprint $table) {

            $table->dropColumn('input_mode');

        });
    }
};