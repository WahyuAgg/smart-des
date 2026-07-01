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
        Schema::table('pengajuan_surat', function (Blueprint $table) {
            $table->foreign('jenis_surat_id')->references('id')->on('jenis_surat')->restrictOnDelete();
            $table->foreign('penduduk_id')->references('id')->on('penduduk')->restrictOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });

        Schema::table('value_field_surat', function (Blueprint $table) {
            $table->foreign('pengajuan_surat_id')->references('id')->on('pengajuan_surat')->cascadeOnDelete();
            $table->foreign('field_surat_id')->references('id')->on('field_surat')->cascadeOnDelete();
        });

        Schema::table('field_surat', function (Blueprint $table) {
            $table->foreign('jenis_surat_id')->references('id')->on('jenis_surat')->cascadeOnDelete();
        });

        Schema::table('ref_profil_desa', function (Blueprint $table) {
            $table->foreign('provinsi_id')->references('id')->on('indonesia_provinces')->restrictOnDelete();
            $table->foreign('kabupaten_id')->references('id')->on('indonesia_cities')->restrictOnDelete();
            $table->foreign('kecamatan_id')->references('id')->on('indonesia_districts')->restrictOnDelete();
            $table->foreign('desa_id')->references('id')->on('indonesia_villages')->restrictOnDelete();
        });

        Schema::table('ref_perangkat_desa', function (Blueprint $table) {
            $table->foreign('jabatan_perangkat_id')->references('id')->on('ref_jabatan_perangkat')->restrictOnDelete();
        });

        Schema::table('ref_rt', function (Blueprint $table) {
            $table->foreign('rw_id')->references('id')->on('ref_rw')->cascadeOnDelete();
        });

        Schema::table('ref_rw', function (Blueprint $table) {
            $table->foreign('dusun_id')->references('id')->on('ref_dusun')->cascadeOnDelete();
        });

        Schema::table('penduduk', function (Blueprint $table) {
            $table->foreign('alamat_id')->references('id')->on('alamat')->cascadeOnDelete();
            $table->foreign('pendidikan_id')->references('id')->on('pendidikan')->cascadeOnDelete();
            $table->foreign('pekerjaan_id')->references('id')->on('pekerjaan')->cascadeOnDelete();
            $table->foreign('kk_id')->references('id')->on('kk')->cascadeOnDelete();
        });

        Schema::table('inv_barang', function (Blueprint $table) {
            $table->foreign('kategori_barang_id')
                ->references('id')
                ->on('inv_kategori_barang')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('lokasi_id')
                ->references('id')
                ->on('inv_lokasi')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });

        Schema::table('inv_detail_peminjaman', function (Blueprint $table) {
            $table->foreign('peminjaman_id')
                ->references('id')
                ->on('inv_peminjaman')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('barang_id')
                ->references('id')
                ->on('inv_barang')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });

        Schema::table('jenis_surat', function (Blueprint $table) {
            $table->foreign('kategori_surat_id')
                ->references('id')
                ->on('kategori_surat')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_surat', function (Blueprint $table) {
            $table->dropForeign(['jenis_surat_id']);
            $table->dropForeign(['penduduk_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::table('value_field_surat', function (Blueprint $table) {
            $table->dropForeign(['pengajuan_surat_id']);
            $table->dropForeign(['field_surat_id']);
        });

        Schema::table('field_surat', function (Blueprint $table) {
            $table->dropForeign(['jenis_surat_id']);
        });

        Schema::table('ref_profil_desa', function (Blueprint $table) {
            $table->dropForeign(['provinsi_id']);
            $table->dropForeign(['kabupaten_id']);
            $table->dropForeign(['kecamatan_id']);
            $table->dropForeign(['desa_id']);
        });

        Schema::table('ref_perangkat_desa', function (Blueprint $table) {
            $table->dropForeign(['jabatan_perangkat_id']);
        });

        Schema::table('ref_rt', function (Blueprint $table) {
            $table->dropForeign(['rw_id']);
        });

        Schema::table('ref_rw', function (Blueprint $table) {
            $table->dropForeign(['dusun_id']);
        });

        Schema::table('penduduk', function (Blueprint $table) {
            $table->dropForeign(['alamat_id']);
            $table->dropForeign(['pendidikan_id']);
            $table->dropForeign(['pekerjaan_id']);
            $table->dropForeign(['kk_id']);
        });

        Schema::table('inv_detail_peminjaman', function (Blueprint $table) {
            $table->dropForeign(['barang_id']);
            $table->dropForeign(['peminjaman_id']);
        });

        Schema::table('inv_barang', function (Blueprint $table) {
            $table->dropForeign(['lokasi_id']);
            $table->dropForeign(['kategori_barang_id']);
        });

        Schema::table('jenis_surat', function (Blueprint $table) {
            $table->dropForeign(['kategori_surat_id']);
        });
    }
};
