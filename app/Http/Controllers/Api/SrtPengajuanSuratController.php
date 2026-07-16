<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SrtPengajuanSurat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use App\Models\SrtJenisSurat;
use App\Models\SrtMasterFieldSurat;

use Illuminate\Support\Collection;
use App\Support\Surat\SystemFieldResolver;

use App\Models\Penduduk;

use App\Services\DocumentConverter;


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
        $records = SrtPengajuanSurat::query()
            ->paginate(15);

        return response()->json($records);
    }

    /**
     * Membuat pengajuan surat baru.
     */
    public function store(Request $request): JsonResponse
    {
        // abort_unless($request->user(), 401, 'Unauthenticated.');

        $data = $request->validate([
            'jenis_surat_id' => ['required', 'exists:srt_jenis_surat,id'],
            'niks'           => ['required', 'array', 'min:1'],
            'niks.*'         => ['required', 'digits:16', 'exists:penduduk,nik'],
            'keperluan' => ['nullable', 'string'],
            'data_surat' => ['nullable', 'array'],
        ]);

        // dd($data);

        $record = SrtPengajuanSurat::create([
            'jenis_surat_id' => $data['jenis_surat_id'],
            'keperluan' => $data['keperluan'] ?? null,
            'data_surat' => $data['data_surat'] ?? null,
            'status' => 'diajukan',
            'tanggal_diajukan' => now(),
            // 'user_id' => $request->user()->id,
        ]);


        $penduduks = Penduduk::query()->whereIn('nik', $data['niks'])->get();

        foreach ($penduduks as $urutan => $penduduk) {
            $record->srtPengajuanSuratPenduduks()->create([
                'penduduk_id' => $penduduk->id,
                'urutan' => $urutan + 1,
            ]);
        }

        $this->getAutoValues($record->id);

        $record->refresh();

        $fields = collect($record->data_surat ?? [])
            ->filter(function ($field) {

                if (empty($field['value'])) {
                    return true;
                }

                return in_array(
                    $field['mode'],
                    [
                        'manual',
                        'auto_editable',
                    ],
                    true
                );
            })
            ->map(function ($field, $placeholder) {
                return [
                    'placeholder' => $placeholder,
                    ...$field,
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'message' => 'Pengajuan surat berhasil dibuat.',
            'requires_input' => $fields->isNotEmpty(),
            'data' => $record->only("id"),
            'fields' => $fields,
        ]);
    }

    /**
     * Detail pengajuan.
     */
    public function show(string $id): JsonResponse
    {
        $record = SrtPengajuanSurat::with([
            'jenisSurat',
            'penduduks',
            'user',
        ])->findOrFail($id);

        return response()->json($record);
    }

    /**
     * Mengubah pengajuan.
     */
    public function update(string $id, Request $request): JsonResponse
    {

        $pengajuan = SrtPengajuanSurat::findOrFail($id);


        $data = $request->validate([
            'data_surat' => ['required', 'array'],
        ]);

        $dataSurat = $pengajuan->data_surat ?? [];

        foreach ($data['data_surat'] as $placeholder => $value) {

            if (! isset($dataSurat[$placeholder])) {
                continue;
            }

            $dataSurat[$placeholder]['value'] = $value;
        }


        $pengajuan->update([
            'data_surat' => $dataSurat,
        ]);

        $pengajuan->refresh();

        $id = $pengajuan->id;

        $this->generate($id);

        $pengajuan->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Surat berhasil diproses dan preview berhasil dibuat.',
            'data' => [
                'id' => $pengajuan->id,
                'status' => $pengajuan->status,
                'nomor_surat' => $pengajuan->nomor_surat,
                'tanggal_diajukan' => $pengajuan->tanggal_diajukan,
                'tanggal_selesai' => $pengajuan->tanggal_selesai,
                'file_hasil' => $pengajuan->file_hasil,
                'preview_url' => asset('storage/' . $pengajuan->file_hasil),
            ],
        ]);
    }

    /**
     * Menghapus pengajuan.
     */
    // public function destroy(string $id): JsonResponse
    // {
    //     $record = SrtPengajuanSurat::findOrFail($id);

    //     $record->delete();

    //     return response()->json(null, 204);
    // }

    // /**
    //  * Approve pengajuan.
    //  */
    // public function approve(string $id): JsonResponse
    // {
    //     $record = SrtPengajuanSurat::findOrFail($id);

    //     $record->update([
    //         'status' => 'disetujui',
    //         'tanggal_diproses' => now(),
    //     ]);

    //     return response()->json($record);
    // }

    // /**
    //  * Tolak pengajuan.
    //  */
    // public function reject(Request $request, string $id): JsonResponse
    // {
    //     $record = SrtPengajuanSurat::findOrFail($id);

    //     $record->update([
    //         'status' => 'ditolak',
    //         'catatan' => $request->input('catatan'),
    //         'tanggal_diproses' => now(),
    //     ]);

    //     return response()->json($record);
    // }

    // /**
    //  * Download surat hasil generate.
    //  */
    // public function download(string $id)
    // {
    //     $record = SrtPengajuanSurat::findOrFail($id);

    //     abort_if(
    //         empty($record->file_hasil),
    //         404,
    //         'File surat belum tersedia.'
    //     );

    //     return response()->download(
    //         storage_path('app/' . $record->file_hasil)
    //     );
    // }


    public function getAutoValues(string $pengajuanSuratId)
    {
        $profilDesa = RefProfilDesa::query()->first();

        $pengajuan = SrtPengajuanSurat::with([
            'jenisSurat',
            'penduduks',
        ])->findOrFail($pengajuanSuratId);

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

        $fields = SrtMasterFieldSurat::all();

        $dataSurat = $pengajuan->data_surat ?? [];

        $this->validatePlaceholders($placeholders, $fields);

        foreach ($placeholders as $placeholder) {

            $field = $this->findField($fields, $placeholder);

            if (! $field) {
                continue;
            }

            $value = $this->resolveFieldValue(
                $pengajuan,
                $profilDesa,
                $field,
                $placeholder
            );

            $dataSurat[$placeholder] = [
                "label" => $field->label,
                "mode" => $field->input_mode,
                "type" => $field->tipe,
                "value" => $value ?: null,
            ];
        }

        $pengajuan->update([
            'data_surat' => $dataSurat,
        ]);

        // return response()->json([
        //     'message' => 'Data surat berhasil diperbarui.',
        //     'data_surat' => $dataSurat,
        // ]);
    }

    /**
     * Generate surat.
     */
    public function generate(string $id)
    {
        $pengajuan = SrtPengajuanSurat::with('jenisSurat')
            ->findOrFail($id);

        $jenisSurat = $pengajuan->jenisSurat;

        if (empty($jenisSurat->template_path)) {
            return response()->json([
                'message' => 'Template surat belum ditentukan.',
            ], 422);
        }

        $templatePath = $this->getTemplatePath(
            $jenisSurat->template_path
        );

        if (! file_exists($templatePath)) {
            return response()->json([
                'message' => 'Template surat tidak ditemukan.',
            ], 404);
        }

        $template = new TemplateProcessor($templatePath);

        // dd($pengajuan->data_surat);

        $this->fillTemplate(
            $template,
            $pengajuan->data_surat ?? []
        );

        $filename = $this->generateFilename($jenisSurat);

        $docxPath = $this->saveDocument(
            $template,
            $filename,
        );

        $pdfPath = $this->konversiPdf($docxPath);

        // Ubah menjadi path relatif untuk database
        // Misal: "generated_surat/pdf/nama_file.pdf"
        $relativePath = 'generated_surat/pdf/' . basename($pdfPath);

        $pengajuan->update([
            'file_hasil' => $relativePath,
            'status' => 'selesai',
            'tanggal_selesai' => now(),
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

        $normalize = fn($value) => preg_replace('/^\d+\./', '', $value);

        $allowed = $fields
            ->pluck('nama')
            ->filter()
            ->map($normalize)
            ->unique()
            ->values()
            ->toArray();

        $invalid = collect($placeholders)
            ->filter(function ($placeholder) use ($allowed, $normalize) {
                return ! in_array($normalize($placeholder), $allowed, true);
            })
            ->values()
            ->toArray();

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
        array $dataSurat
    ): void {

        foreach ($dataSurat as $placeholder => $field) {

            $template->setValue(
                $placeholder,
                $field['value'] ?? ''
            );
        }
    }

    private function findField(Collection $fields, string $placeholder)
    {
        return $fields->first(function ($field) use ($placeholder) {
            return $field->nama === $placeholder
                || preg_replace('/^\d+\./', '', $field->nama)
                === preg_replace('/^\d+\./', '', $placeholder);
        });
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


    public function konversiPdf(string $pathDocx,): string
    {
        $converter = new DocumentConverter();

        try {
            $pdfPath = $converter->docxToPdf($pathDocx);

            return $pdfPath;
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }



    private function saveDocument(TemplateProcessor $template, string $filename): string
    {
        // Cukup simpan di satu folder yang sama agar mudah dikelola
        $directory = storage_path('app/public/generated_surat');
        File::ensureDirectoryExists($directory);

        $docxPath = $directory . DIRECTORY_SEPARATOR . $filename;
        $template->saveAs($docxPath);

        return $docxPath;
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
        $field,
        string $placeholder
    ): mixed {

        if ($field->source === 'penduduk') {

            $penduduk = null;
            $sourceField = $field->source_field;

            if (preg_match('/^(\d+)\./', $placeholder, $matches)) {

                $urutan = (int) $matches[1];

                $penduduk = $pengajuan
                    ->penduduks
                    ->firstWhere('pivot.urutan', $urutan);
            } else {

                // fallback jika suatu saat ada field lama tanpa prefix
                $penduduk = $pengajuan->penduduks->first();
            }

            $value = data_get($penduduk, $sourceField);
        } else {

            $value = match ($field->source) {
                'pengajuan' => data_get($pengajuan, $field->source_field),
                'profil_desa' => data_get($profilDesa, $field->source_field),
                'data_surat' => data_get($pengajuan->data_surat, $field->source_field),
                'system' => $this->systemFieldResolver->resolve(
                    $pengajuan,
                    $field->source_field
                ),
                default => null,
            };
        }

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
