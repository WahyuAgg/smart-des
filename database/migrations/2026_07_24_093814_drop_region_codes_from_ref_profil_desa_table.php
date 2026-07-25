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
        // Schema::disableForeignKeyConstraints();

        Schema::table('ref_profil_desa', function (Blueprint $table) {

            $table->dropForeign(['provinsi_code']);
            $table->dropForeign(['kabupaten_code']);
            $table->dropForeign(['kecamatan_code']);
            $table->dropForeign(['desa_code']);

            $table->dropColumn([
                'provinsi_code',
                'kabupaten_code',
                'kecamatan_code',
                'desa_code',
            ]);
        });

        // Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ref_profil_desa', function (Blueprint $table) {
            $table->string('provinsi_code')->nullable();
            $table->string('kabupaten_code')->nullable();
            $table->string('kecamatan_code')->nullable();
            $table->string('desa_code')->nullable();
        });
    }
};
