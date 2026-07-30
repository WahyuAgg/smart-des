<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penduduk', function (Blueprint $table) {
            $table->enum('jenis_kelamin', ['L', 'P'])->change();
        });
    }

    public function down(): void
    {
        Schema::table('penduduk', function (Blueprint $table) {
            $table->string('jenis_kelamin')->change();
        });
    }
};