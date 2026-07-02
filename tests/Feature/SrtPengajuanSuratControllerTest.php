<?php

namespace Tests\Feature;

use App\Models\Alamat;
use App\Models\Kk;
use App\Models\Penduduk;
use App\Models\Pendidikan;
use App\Models\Pekerjaan;
use App\Models\SrtJenisSurat;
use App\Models\SrtKategoriSurat;
use App\Models\SrtMasterFieldSurat;
use App\Models\SrtPengajuanSurat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007;
use Tests\TestCase;

class SrtPengajuanSuratControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_requires_authenticated_user(): void
    {
        $response = $this->postJson('/api/srt-pengajuan-surat', [
            'jenis_surat_id' => 1,
            'penduduk_id' => 1,
            'keperluan' => 'Test',
        ]);

        $response->assertStatus(401);
    }

    public function test_generate_creates_document_and_updates_pengajuan(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $alamat = Alamat::create([
            'alamat_lengkap' => 'Test alamat',
            'jalan' => 'Jalan Test',
            'rt' => '1',
            'rw' => '2',
            'desa' => 'Test',
            'kecamatan' => 'Test',
            'kabupaten' => 'Test',
            'provinsi' => 'Test',
            'kode_pos' => '12345',
            'latitude' => 0,
            'longitude' => 0,
        ]);
        $pendidikan = Pendidikan::create(['tingkat_pendidikan' => 'SMA']);
        $pekerjaan = Pekerjaan::create(['nama_pekerjaan' => 'Wiraswasta']);
        $kk = Kk::create(['no_kk' => '1234567890123456', 'nik_kepala_keluarga' => '1234567890123456']);

        $penduduk = Penduduk::create([
            'nik' => '1234567890123456',
            'nama_lengkap' => 'Test Penduduk',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Test',
            'tanggal_lahir' => '1990-01-01',
            'agama' => 'Islam',
            'status_perkawinan' => 'Belum Kawin',
            'kewarganegaraan' => 'WNI',
            'golongan_darah' => 'O',
            'no_hp' => '081234567890',
            'email' => 'test@example.com',
            'alamat_id' => $alamat->id,
            'pendidikan_id' => $pendidikan->id,
            'pekerjaan_id' => $pekerjaan->id,
            'kk_id' => $kk->id,
            'status_hidup' => 'hidup',
        ]);

        $kategoriSurat = SrtKategoriSurat::create(['nama_kategori_surat' => 'Umum']);

        $jenisSurat = SrtJenisSurat::create([
            'kategori_surat_id' => $kategoriSurat->id,
            'kode_jenis_surat' => 'SKTM',
            'nama_jenis_surat' => 'Surat Keterangan Tidak Mampu',
            'template_path' => 'templates/test.docx',
            'is_active' => true,
        ]);

        $fieldNama = SrtMasterFieldSurat::create([
            'nama' => 'nama_lengkap',
            'label' => 'Nama Lengkap',
            'source' => 'penduduk',
            'source_field' => 'nama_lengkap',
        ]);

        $fieldKeperluan = SrtMasterFieldSurat::create([
            'nama' => 'keperluan',
            'label' => 'Keperluan',
            'source' => 'pengajuan',
            'source_field' => 'keperluan',
        ]);

        $jenisSurat->srtMasterFieldSurat()->attach([
            $fieldNama->id => ['wajib' => true, 'urutan' => 1],
            $fieldKeperluan->id => ['wajib' => true, 'urutan' => 2],
        ]);

        $pengajuan = SrtPengajuanSurat::create([
            'jenis_surat_id' => $jenisSurat->id,
            'penduduk_id' => $penduduk->id,
            'keperluan' => 'Keperluan uji coba',
            'status' => 'diajukan',
            'user_id' => $user->id,
        ]);

        $templatePath = storage_path('app/public/templates/test.docx');
        $directory = dirname($templatePath);
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $section->addText('Nama: ${nama_lengkap}');
        $section->addText('Keperluan: ${keperluan}');

        $writer = new Word2007($phpWord);
        $writer->save($templatePath);

        $response = $this->actingAs($user)->postJson('/api/srt-pengajuan-surat/' . $pengajuan->id . '/generate');

        $response->assertStatus(200);
        $response->assertJsonPath('message', 'Surat berhasil digenerate.');

        $pengajuan->refresh();
        $this->assertNotNull($pengajuan->file_hasil);
        $this->assertSame('selesai', $pengajuan->status);
        $this->assertNotNull($pengajuan->tanggal_selesai);
    }
}
