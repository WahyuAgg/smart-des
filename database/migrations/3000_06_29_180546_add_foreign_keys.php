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
        Schema::table('srt_pengajuan_surat', function (Blueprint $table) {
            $table->foreign('jenis_surat_id')->references('id')->on('srt_jenis_surat')->restrictOnDelete();
            // $table->foreign('penduduk_id')->references('id')->on('penduduk')->restrictOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });


        // Schema::table('ref_profil_desa', function (Blueprint $table) {
        //     $table->foreign('provinsi_code')->references('code')->on('indonesia_provinces')->restrictOnDelete();
        //     $table->foreign('kabupaten_code')->references('code')->on('indonesia_cities')->restrictOnDelete();
        //     $table->foreign('kecamatan_code')->references('code')->on('indonesia_districts')->restrictOnDelete();
        //     $table->foreign('desa_code')->references('code')->on('indonesia_villages')->restrictOnDelete();
        // });

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

        Schema::table('srt_jenis_surat', function (Blueprint $table) {
            $table->foreign('kategori_surat_id')
                ->references('id')
                ->on('srt_kategori_surat')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });

        Schema::table('srt_pengajuan_surat_penduduk', function (Blueprint $table) {
            $table->foreign('pengajuan_surat_id')
                ->references('id')
                ->on('srt_pengajuan_surat')
                ->cascadeOnDelete();

            $table->foreign('penduduk_id')
                ->references('id')
                ->on('penduduk')
                ->cascadeOnDelete();
        });

        Schema::table('srt_jenis_surat_penduduk', function (Blueprint $table) {
            $table->foreign('jenis_surat_id')
                ->references('id')
                ->on('srt_jenis_surat')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('srt_pengajuan_surat', function (Blueprint $table) {
            $table->dropForeign(['jenis_surat_id']);
            // $table->dropForeign(['penduduk_id']);
            $table->dropForeign(['user_id']);
        });

        // Schema::table('ref_profil_desa', function (Blueprint $table) {
        //     $table->dropForeign(['provinsi_code']);
        //     $table->dropForeign(['kabupaten_code']);
        //     $table->dropForeign(['kecamatan_code']);
        //     $table->dropForeign(['desa_code']);
        // });

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

        Schema::table('srt_jenis_surat', function (Blueprint $table) {
            $table->dropForeign(['kategori_surat_id']);
        });

        Schema::table('srt_pengajuan_surat_penduduk', function (Blueprint $table) {
            // Nama constraint biasanya mengikuti pola: [nama_tabel]_[nama_kolom]_foreign
            $table->dropForeign(['pengajuan_surat_id']);
            $table->dropForeign(['penduduk_id']);
        });
    }
};
