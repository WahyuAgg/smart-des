<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StorePaperRequest;
use App\Http\Requests\UpdatePaperRequest;
use App\Models\Paper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PaperController extends ApiController
{
    protected int $defaultPerPage = 15;
    protected int $maxPerPage = 100;

    public function index(Request $request): JsonResponse
    {
        $perPage = min((int) $request->input('per_page', $this->defaultPerPage), $this->maxPerPage);

        $query = Paper::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Search by judul or penulis
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('nama_penulis', 'like', "%{$search}%");
            });
        }

        // Filter by tahun
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->input('tahun'));
        }

        $records = $query->latest()->paginate($perPage);

        return $this->success($records);
    }

    public function store(StorePaperRequest $request): JsonResponse
    {
        try {
            $result = DB::transaction(function () use ($request) {
                $data = $request->only([
                    'judul',
                    'ringkasan',
                    'nama_penulis',
                    'tahun',
                    'jumlah_halaman',
                    'status',
                ]);

                // Auto-generate slug if not provided
                $data['slug'] = $request->input('slug', Str::slug($data['judul']));

                // Ensure unique slug
                $baseSlug = $data['slug'];
                $counter = 1;
                while (Paper::where('slug', $data['slug'])->exists()) {
                    $data['slug'] = $baseSlug . '-' . $counter;
                    $counter++;
                }

                // Handle PDF upload
                if ($request->hasFile('pdf')) {
                    $data['pdf_path'] = $request->file('pdf')->store('papers/pdf', 'public');
                }

                // Handle thumbnail upload
                if ($request->hasFile('thumbnail')) {
                    $data['thumbnail_path'] = $request->file('thumbnail')->store('papers/thumbnail', 'public');
                }

                return Paper::create($data);
            });

            return $this->success(
                $result->fresh(),
                'Paper berhasil ditambahkan.',
                201
            );
        } catch (\Throwable $e) {
            return $this->error(
                'Gagal menyimpan paper: ' . $e->getMessage(),
                null,
                500
            );
        }
    }

    public function show(int $id): JsonResponse
    {
        $record = Paper::findOrFail($id);

        return $this->success($record);
    }

    public function update(UpdatePaperRequest $request, int $id): JsonResponse
    {
        $record = Paper::findOrFail($id);
        // dd($request->all());

        try {
            DB::transaction(function () use ($request, $record) {
                $data = $request->only([
                    'judul',
                    'ringkasan',
                    'nama_penulis',
                    'tahun',
                    'jumlah_halaman',
                    'status',
                ]);

                // Handle slug
                if ($request->filled('slug')) {
                    $data['slug'] = $request->input('slug');
                } elseif ($request->filled('judul') && !$request->filled('slug')) {
                    $data['slug'] = Str::slug($request->input('judul'));
                }

                // Handle PDF upload — delete old file if exists
                if ($request->hasFile('pdf')) {
                    if ($record->pdf_path && Storage::disk('public')->exists($record->pdf_path)) {
                        Storage::disk('public')->delete($record->pdf_path);
                    }
                    $data['pdf_path'] = $request->file('pdf')->store('papers/pdf', 'public');
                }

                // Handle thumbnail upload — delete old file if exists
                if ($request->hasFile('thumbnail')) {
                    if ($record->thumbnail_path && Storage::disk('public')->exists($record->thumbnail_path)) {
                        Storage::disk('public')->delete($record->thumbnail_path);
                    }
                    $data['thumbnail_path'] = $request->file('thumbnail')->store('papers/thumbnail', 'public');
                }

                $record->update($data);
            });

            return $this->success(
                $record->fresh(),
                'Paper berhasil diperbarui.'
            );
        } catch (\Throwable $e) {
            return $this->error(
                'Gagal memperbarui paper: ' . $e->getMessage(),
                null,
                500
            );
        }
    }

    public function destroy(int $id): JsonResponse
    {
        $record = Paper::findOrFail($id);

        try {
            DB::transaction(function () use ($record) {
                // Delete stored files
                if ($record->pdf_path && Storage::disk('public')->exists($record->pdf_path)) {
                    Storage::disk('public')->delete($record->pdf_path);
                }
                if ($record->thumbnail_path && Storage::disk('public')->exists($record->thumbnail_path)) {
                    Storage::disk('public')->delete($record->thumbnail_path);
                }

                $record->delete();
            });

            return $this->success(
                null,
                'Paper berhasil dihapus.'
            );
        } catch (\Throwable $e) {
            return $this->error(
                'Gagal menghapus paper: ' . $e->getMessage(),
                null,
                500
            );
        }
    }
}