<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('pekerjaan');
    }

    public function down(): void
    {
        Schema::create('pekerjaan', function ($table) {
            $table->id();
            $table->string('nama_pekerjaan');
            $table->timestamps();
        });
    }
};