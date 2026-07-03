<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SrtPengajuanSurat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use App\Models\SrtJenisSurat;
use App\Models\SrtMasterFieldSurat;

use Illuminate\Support\Collection;
use App\Support\Surat\SystemFieldResolver;


use PhpOffice\PhpWord\TemplateProcessor;
use App\Models\RefProfilDesa;
use ZipArchive;


class SrtPengajuanSuratController extends Controller
{
    /**
     * Daftar pengajuan surat.
     */
    public function index(): JsonResponse
    {
        $records = SrtPengajuanSurat::with([
            'jenisSurat',
            'penduduk',
            'user',
        ])
            ->latest()
            ->paginate(15);

        return response()->json($records);
    }

    /**
     * Membuat pengajuan surat baru.
     */
    public function store(Request $request): JsonResponse
    {
        abort_unless($request->user(), 401, 'Unauthenticated.');

        $data = $request->validate([
            'jenis_surat_id' => ['required', 'exists:srt_jenis_surat,id'],
            'penduduk_id' => ['required', 'exists:penduduk,id'],
            'keperluan' => ['nullable', 'string'],
            'data_surat' => ['nullable', 'array'],
        ]);

        $data['status'] = 'diajukan';
        $data['tanggal_diajukan'] = now();
        $data['user_id'] = $request->user()->id;

        $record = SrtPengajuanSurat::create($data);

        return response()->json(
            $record->load([
                'jenisSurat',
                'penduduk',
                'user',
            ]),
            201
        );
    }

    /**
     * Detail pengajuan.
     */
    public function show(string $id): JsonResponse
    {
        $record = SrtPengajuanSurat::with([
            'jenisSurat',
            'penduduk',
            'user',
        ])->findOrFail($id);

        return response()->json($record);
    }

    /**
     * Mengubah pengajuan.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $record = SrtPengajuanSurat::findOrFail($id);

        $record->fill(
            $request->only([
                'keperluan',
                'catatan',
            ])
        );

        $record->save();

        return response()->json(
            $record->fresh([
                'jenisSurat',
                'penduduk',
                'user',
            ])
        );
    }

    /**
     * Menghapus pengajuan.
     */
    public function destroy(string $id): JsonResponse
    {
        $record = SrtPengajuanSurat::findOrFail($id);

        $record->delete();

        return response()->json(null, 204);
    }

    /**
     * Approve pengajuan.
     */
    public function approve(string $id): JsonResponse
    {
        $record = SrtPengajuanSurat::findOrFail($id);

        $record->update([
            'status' => 'disetujui',
            'tanggal_diproses' => now(),
        ]);

        return response()->json($record);
    }

    /**
     * Tolak pengajuan.
     */
    public function reject(Request $request, string $id): JsonResponse
    {
        $record = SrtPengajuanSurat::findOrFail($id);

        $record->update([
            'status' => 'ditolak',
            'catatan' => $request->input('catatan'),
            'tanggal_diproses' => now(),
        ]);

        return response()->json($record);
    }

    /**
     * Download surat hasil generate.
     */
    public function download(string $id)
    {
        $record = SrtPengajuanSurat::findOrFail($id);

        abort_if(
            empty($record->file_hasil),
            404,
            'File surat belum tersedia.'
        );

        return response()->download(
            storage_path('app/' . $record->file_hasil)
        );
    }

    /**
     * Generate surat.
     */
    public function generate(string $id): JsonResponse
    {
        $pengajuan = SrtPengajuanSurat::with([
            'jenisSurat',
            'penduduk',
        ])->findOrFail($id);

        $jenisSurat = $pengajuan->jenisSurat;

        if (empty($jenisSurat->template_path)) {
            return response()->json([
                'message' => 'Template surat belum ditentukan.',
            ], 422);
        }

        $templatePath = $this->getTemplatePath($jenisSurat->template_path);

        if (! file_exists($templatePath)) {
            return response()->json([
                'message' => 'Template surat tidak ditemukan.',
            ], 404);
        }

        $placeholders = $this->extractPlaceholders($templatePath);

        $this->validatePlaceholders(
            $placeholders,
            SrtMasterFieldSurat::select('nama')->get()
        );

        $template = new TemplateProcessor($templatePath);

        $this->fillTemplate(
            $template,
            $pengajuan,
            RefProfilDesa::query()->first(),
            $placeholders
        );

        $filename = $this->generateFilename($jenisSurat);

        $outputPath = $this->saveDocument(
            $template,
            $filename
        );

        $pengajuan->update([
            'file_hasil' => 'generated/' . $filename,
            'status' => 'selesai',
            'tanggal_selesai' => now(),
        ]);

        return response()->json([
            'message' => 'Surat berhasil digenerate.',
            'file' => asset('storage/generated/' . basename($outputPath)),
        ]);
    }

    private function getTemplatePath(string $path): string
    {
        return storage_path($path);
    }


    private function validatePlaceholders(
        array $placeholders,
        Collection $fields
    ): void {

        $allowed = $fields
            ->pluck('nama')
            ->filter()
            ->toArray();

        $invalid = array_values(
            array_diff($placeholders, $allowed)
        );

        if (! empty($invalid)) {
            abort(
                response()->json([
                    'message' => 'Placeholder tidak terdaftar.',
                    'placeholder' => $invalid,
                ], 422)
            );
        }
    }

    private function fillTemplate(
        TemplateProcessor $template,
        SrtPengajuanSurat $pengajuan,
        ?RefProfilDesa $profilDesa,
        array $placeholders
    ): void {

        $fields = SrtMasterFieldSurat::all();


        foreach ($placeholders as $placeholder) {

            $field = $fields->firstWhere(
                'nama',
                $placeholder
            );

            if (! $field) {
                continue;
            }

            $value = $this->resolveFieldValue(
                $pengajuan,
                $profilDesa,
                $field
            );

            $template->setValue(
                $placeholder,
                $value ?? ''
            );
        }
    }

    private function generateFilename(
        SrtJenisSurat $jenisSurat
    ): string {

        return sprintf(
            '%s_%s.docx',
            $jenisSurat->kode_jenis_surat ?: 'surat',
            now()->format('YmdHis')
        );
    }



    private function saveDocument(
        TemplateProcessor $template,
        string $filename
    ): string {

        $directory = storage_path('app/public/generated');

        File::ensureDirectoryExists($directory);

        $outputPath = $directory . DIRECTORY_SEPARATOR . $filename;

        $template->saveAs($outputPath);

        return $outputPath;
    }

    // use App\Support\Surat\SystemFieldResolver;

    private SystemFieldResolver $systemFieldResolver;

    public function __construct()
    {
        $this->systemFieldResolver = new SystemFieldResolver();
    }

    private function resolveFieldValue(
        SrtPengajuanSurat $pengajuan,
        ?RefProfilDesa $profilDesa,
        $field
    ): mixed {
        $value = match ($field->source) {
            'penduduk' => data_get($pengajuan->penduduk, $field->source_field),
            'pengajuan' => data_get($pengajuan, $field->source_field),
            'profil_desa' => data_get($profilDesa, $field->source_field),
            'data_surat' => data_get($pengajuan->data_surat, $field->source_field),
            'system' => $this->systemFieldResolver->resolve($pengajuan, $field->source_field),
            default => null,
        };

        if ($value instanceof \Carbon\Carbon) {
            return $value->translatedFormat('d-M-Y');
        }

        if ($value instanceof \DateTimeInterface) {
            return $value->format('d-M-Y');
        }

        if (is_array($value)) {
            return implode(', ', array_filter($value));
        }

        return $value;
    }

    private function extractPlaceholders(string $docxPath): array
    {
        $zip = new ZipArchive();

        if ($zip->open($docxPath) !== true) {
            throw new \RuntimeException('Gagal membuka file DOCX.');
        }

        $xml = '';

        // Document utama
        if (($index = $zip->locateName('word/document.xml')) !== false) {
            $xml .= $zip->getFromIndex($index);
        }

        // Header
        for ($i = 1; $i <= 5; $i++) {

            $name = "word/header{$i}.xml";

            if (($index = $zip->locateName($name)) !== false) {
                $xml .= $zip->getFromIndex($index);
            }
        }

        // Footer
        for ($i = 1; $i <= 5; $i++) {

            $name = "word/footer{$i}.xml";

            if (($index = $zip->locateName($name)) !== false) {
                $xml .= $zip->getFromIndex($index);
            }
        }

        $zip->close();

        preg_match_all('/\$\{([^\}]+)\}/', $xml, $matches);

        return array_values(array_unique($matches[1]));
    }
}
