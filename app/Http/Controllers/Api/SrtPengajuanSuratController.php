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

use App\Models\Penduduk;


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
        abort_unless($request->user(), 401, 'Unauthenticated.');

        $data = $request->validate([
            'jenis_surat_id' => ['required', 'exists:srt_jenis_surat,id'],
            'niks'           => ['required', 'array', 'min:1'], 
            'niks.*'         => ['required', 'exists:penduduk,nik'],
            'keperluan' => ['nullable', 'string'],
            'data_surat' => ['nullable', 'array'],
        ]);

        $record = SrtPengajuanSurat::create([
            'jenis_surat_id' => $data['jenis_surat_id'],
            'keperluan' => $data['keperluan'] ?? null,
            'data_surat' => $data['data_surat'] ?? null,
            'status' => 'diajukan',
            'tanggal_diajukan' => now(),
            'user_id' => $request->user()->id,
        ]);

        $penduduks = Penduduk::query()->whereIn('nik', $data['niks'])->get();

        foreach ($penduduks as $urutan => $penduduk) {
            $record->srtPengajuanSuratPenduduks()->create([
                'penduduk_id' => $penduduk->id,
                'urutan' => $urutan + 1,
            ]);
        }

        return response()->json(
            $record->load([
                'jenisSurat',
                'penduduks',
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
            'penduduks',
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
            'penduduks',
        ])->findOrFail($id);

        // return response()->json($pengajuan);

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

        // dd($placeholders);

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
        SrtPengajuanSurat $pengajuan,
        ?RefProfilDesa $profilDesa,
        array $placeholders
    ): void {

        $fields = SrtMasterFieldSurat::all();

        // dd($placeholders, $fields->pluck('nama')->toArray());


        foreach ($placeholders as $placeholder) {

            $field = $this->findField($fields, $placeholder);

            

            // abort(response()->json(['placeholder' => $placeholder], 422));

            // if (! $field) {
            //     continue;
            // }

            $value = $this->resolveFieldValue(
                $pengajuan,
                $profilDesa,
                $field,
                $placeholder
            );

            // dd($placeholder, $value);

            $template->setValue(
                $placeholder,
                $value ?? ''
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
