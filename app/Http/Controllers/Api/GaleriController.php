<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreGaleriRequest;
use App\Http\Requests\UpdateGaleriRequest;
use App\Models\Galeri;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GaleriController extends ApiController
{
    protected int $defaultPerPage = 15;
    protected int $maxPerPage = 100;

    /**
     * Display a paginated listing of gallery items.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min((int) $request->input('per_page', $this->defaultPerPage), $this->maxPerPage);

        $query = Galeri::query();

        // Filter by published status
        if ($request->filled('is_published')) {
            $query->where('is_published', filter_var($request->input('is_published'), FILTER_VALIDATE_BOOLEAN));
        }

        // Search by judul or deskripsi
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $records = $query->latest()->paginate($perPage);

        return $this->success($records);
    }

    /**
     * Store a newly created gallery item.
     */
    public function store(StoreGaleriRequest $request): JsonResponse
    {
        try {
            $result = DB::transaction(function () use ($request) {
                $data = $request->only([
                    'judul',
                    'deskripsi',
                    'tanggal',
                    'is_published',
                ]);

                // Set default tanggal to today if not provided
                if (empty($data['tanggal'])) {
                    $data['tanggal'] = now()->toDateString();
                }

                // Handle file upload
                if ($request->hasFile('file')) {
                    $data['file_path'] = $request->file('file')->store('galeri', 'public');
                }

                return Galeri::create($data);
            });

            return $this->success(
                $result->fresh(),
                'Galeri berhasil ditambahkan.',
                201
            );
        } catch (\Throwable $e) {
            return $this->error(
                'Gagal menyimpan galeri: ' . $e->getMessage(),
                null,
                500
            );
        }
    }

    /**
     * Display the specified gallery item.
     */
    public function show(int $id): JsonResponse
    {
        $record = Galeri::findOrFail($id);

        return $this->success($record);
    }

    /**
     * Update the specified gallery item.
     */
    public function update(UpdateGaleriRequest $request, int $id): JsonResponse
    {
        $record = Galeri::findOrFail($id);

        try {
            DB::transaction(function () use ($request, $record) {
                $data = $request->only([
                    'judul',
                    'deskripsi',
                    'tanggal',
                    'is_published',
                ]);

                // Handle file upload — delete old file if exists
                if ($request->hasFile('file')) {
                    if ($record->file_path && Storage::disk('public')->exists($record->file_path)) {
                        Storage::disk('public')->delete($record->file_path);
                    }
                    $data['file_path'] = $request->file('file')->store('galeri', 'public');
                }

                $record->update($data);
            });

            return $this->success(
                $record->fresh(),
                'Galeri berhasil diperbarui.'
            );
        } catch (\Throwable $e) {
            return $this->error(
                'Gagal memperbarui galeri: ' . $e->getMessage(),
                null,
                500
            );
        }
    }

    /**
     * Remove the specified gallery item.
     */
    public function destroy(int $id): JsonResponse
    {
        $record = Galeri::findOrFail($id);

        try {
            DB::transaction(function () use ($record) {
                // Delete file from storage
                if ($record->file_path && Storage::disk('public')->exists($record->file_path)) {
                    Storage::disk('public')->delete($record->file_path);
                }

                $record->delete();
            });

            return $this->success(
                null,
                'Galeri berhasil dihapus.'
            );
        } catch (\Throwable $e) {
            return $this->error(
                'Gagal menghapus galeri: ' . $e->getMessage(),
                null,
                500
            );
        }
    }
}