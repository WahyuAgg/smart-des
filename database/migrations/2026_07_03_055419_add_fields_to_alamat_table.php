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
        Schema::table('alamat', function (Blueprint $table) {
            // Menambahkan label alamat (Rumah, Kantor, dll) di awal setelah ID
            $table->string('label_alamat')->nullable()->after('id');
            
            // Menentukan apakah ini alamat utama
            $table->boolean('is_utama')->default(false)->after('label_alamat');

            // Menambahkan detail spesifik bangunan setelah kolom 'jalan'
            $table->string('nama_gedung_perumahan')->nullable()->after('jalan');
            $table->string('nomor_rumah', 20)->nullable()->after('nama_gedung_perumahan');
            $table->string('blok', 20)->nullable()->after('nomor_rumah');
            $table->string('no_lantai', 10)->nullable()->after('blok');
            $table->string('no_unit', 10)->nullable()->after('no_lantai');

            // Menambahkan catatan kurir/patokan setelah 'kode_pos'
            $table->text('patokan')->nullable()->after('kode_pos');
            
            // Menambahkan negara jika diperlukan setelah 'provinsi'
            $table->string('negara')->default('Indonesia')->after('provinsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alamat', function (Blueprint $table) {
            // Drop kolom jika migration di-rollback
            $table->dropColumn([
                'label_alamat',
                'is_utama',
                'nama_gedung_perumahan',
                'nomor_rumah',
                'blok',
                'no_lantai',
                'no_unit',
                'patokan',
                'negara'
            ]);
        });
    }
};