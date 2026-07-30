<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE penduduk
            ADD CONSTRAINT chk_penduduk_jenis_kelamin
            CHECK (jenis_kelamin IN ('L', 'P'))
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE penduduk
            DROP CHECK chk_penduduk_jenis_kelamin
        ");
    }
};