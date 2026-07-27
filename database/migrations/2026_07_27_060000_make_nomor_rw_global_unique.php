<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ref_rw', function (Blueprint $table) {
            // Drop composite unique (dusun_id, nomor_rw)
            // $table->dropUnique(['dusun_id', 'nomor_rw']);

            // Add global unique on nomor_rw
            $table->string('nomor_rw', 3)->unique()->change();
        });
    }

    public function down(): void
    {
        Schema::table('ref_rw', function (Blueprint $table) {
            $table->dropUnique(['nomor_rw']);

            // Restore composite unique
            // $table->unique(['dusun_id', 'nomor_rw']);
        });
    }
};