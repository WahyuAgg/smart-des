<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alamat', function (Blueprint $table) {
            $table->renameColumn('nama_gedung_perumahan', 'gedung_perumahan');
        });
    }

    public function down(): void
    {
        Schema::table('alamat', function (Blueprint $table) {
            $table->renameColumn('gedung_perumahan', 'nama_gedung_perumahan');
        });
    }
};
