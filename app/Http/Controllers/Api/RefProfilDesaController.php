<?php

namespace App\Http\Controllers\Api;

use App\Models\RefProfilDesa;
use App\Http\Requests\StoreRefProfilDesaRequest;
use App\Http\Requests\UpdateRefProfilDesaRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Laravolt\Indonesia\Models\Village;
use App\Models\RefKecamatan;
use Illuminate\Support\Facades\Storage;

/**
 * TODO: Edit this Controller to extend from ApiController instead of CrudController
 * Dev 29/07/26: well i'm stil conflicted about that since it use array $with* that is very useful
 */
class RefProfilDesaController extends CrudController
{
    protected string $modelClass = RefProfilDesa::class;

    protected array $withShow = [];

    protected array $withIndex = [];

    protected array $appends = [
        'kode_pos',
        'nama_provinsi',
        'nama_kabupaten',
        'nama_kecamatan',
        'nama_desa',
        'profil_kecamatan',
        'kades',
    ];

    private function formatWilayah(RefProfilDesa $record): array
    {
        $village = Village::with('district.city.province')
            ->where('code', $record->kode)
            ->first();

        if (!$village) {
            return [
                'desa' => null,
                'kecamatan' => null,
                'kabupaten' => null,
                'provinsi' => null,
            ];
        }

        $district = $village->district;
        $city = $district?->city;
        $province = $city?->province;

        return [
            'desa' => $village ? [
                'id' => $village->id,
                'code' => $village->code,
                'name' => $village->name,
            ] : null,
            'kecamatan' => $district ? [
                'id' => $district->id,
                'code' => $district->code,
                'name' => $district->name,
            ] : null,
            'kabupaten' => $city ? [
                'id' => $city->id,
                'code' => $city->code,
                'name' => $city->name,
            ] : null,
            'provinsi' => $province ? [
                'id' => $province->id,
                'code' => $province->code,
                'name' => $province->name,
            ] : null,
        ];
    }

    private function buildResponse(RefProfilDesa $record): array
    {
        $record->append($this->appends);

        $data = $record->toArray();
        $data = array_merge($data, $this->formatWilayah($record));

        unset(
            $data['provinsi_code'],
            $data['kabupaten_code'],
            $data['kecamatan_code'],
            $data['desa_code'],
        );

        return $data;
    }

    public function storeProfilDesa(StoreRefProfilDesaRequest $request): JsonResponse
    {
        $profilDesa = $this->resolveModel();

        // Only allow one record
        if ($profilDesa->newQuery()->exists()) {
            return $this->error(
                'Profil desa sudah ada. Gunakan endpoint update untuk mengubah data.',
                null,
                409
            );
        }

        try {
            $result = DB::transaction(function () use ($request, $profilDesa) {
                // Handle file uploads for ProfilDesa
                $dataDesa = $request->only($profilDesa->getFillable());

                if ($request->hasFile('logo')) {
                    $dataDesa['logo'] = $request->file('logo')->store('logo', 'public');
                }

                if ($request->hasFile('peta_pdf')) {
                    $dataDesa['peta_pdf'] = $request->file('peta_pdf')->store('peta_pdf', 'public');
                }

                $profilDesaBaru = $profilDesa->newQuery()->create($dataDesa);

                // Handle file uploads for RefKecamatan
                $dataKecamatan = $request->input('profil_kecamatan', []);

                if ($request->hasFile('profil_kecamatan.foto')) {
                    $dataKecamatan['foto'] = $request->file('profil_kecamatan.foto')
                        ->store('kecamatan', 'public');
                }

                if ($request->hasFile('profil_kecamatan.tanda_tangan')) {
                    $dataKecamatan['tanda_tangan'] = $request->file('profil_kecamatan.tanda_tangan')
                        ->store('kecamatan', 'public');
                }

                RefKecamatan::query()->create($dataKecamatan);

                return $profilDesaBaru;
            });

            return $this->success(
                $this->buildResponse($result->fresh()),
                'Profil desa berhasil ditambahkan.',
                201
            );
        } catch (\Throwable $e) {
            return $this->error(
                'Gagal menyimpan profil desa: ' . $e->getMessage(),
                null,
                500
            );
        }
    }

    public function showProfilDesa(): JsonResponse
    {
        $record = $this->resolveModel()
            ->newQuery()
            ->firstOrFail();

        return $this->success($this->buildResponse($record));
    }

    public function updateProfilDesa(UpdateRefProfilDesaRequest $request): JsonResponse
    {
        $record = $this->resolveModel()
            ->newQuery()
            ->firstOrFail();

        try {
            DB::transaction(function () use ($request, $record) {
                // Handle file uploads for ProfilDesa
                $dataDesa = $request->only($record->getFillable());

                if ($request->hasFile('logo')) {
                    // Delete old file if exists
                    if ($record->logo && Storage::disk('public')->exists($record->logo)) {
                        Storage::disk('public')->delete($record->logo);
                    }
                    $dataDesa['logo'] = $request->file('logo')->store('logo', 'public');
                }

                if ($request->hasFile('peta_pdf')) {
                    if ($record->peta_pdf && Storage::disk('public')->exists($record->peta_pdf)) {
                        Storage::disk('public')->delete($record->peta_pdf);
                    }
                    $dataDesa['peta_pdf'] = $request->file('peta_pdf')->store('peta_pdf', 'public');
                }

                $record->update($dataDesa);

                // Handle file uploads for RefKecamatan
                $profilKecamatan = RefKecamatan::query()->first();
                if ($profilKecamatan) {
                    $dataKecamatan = $request->input('profil_kecamatan', []);

                    if ($request->hasFile('profil_kecamatan.foto')) {
                        if ($profilKecamatan->foto && Storage::disk('public')->exists($profilKecamatan->foto)) {
                            Storage::disk('public')->delete($profilKecamatan->foto);
                        }
                        $dataKecamatan['foto'] = $request->file('profil_kecamatan.foto')
                            ->store('kecamatan', 'public');
                    }

                    if ($request->hasFile('profil_kecamatan.tanda_tangan')) {
                        if ($profilKecamatan->tanda_tangan && Storage::disk('public')->exists($profilKecamatan->tanda_tangan)) {
                            Storage::disk('public')->delete($profilKecamatan->tanda_tangan);
                        }
                        $dataKecamatan['tanda_tangan'] = $request->file('profil_kecamatan.tanda_tangan')
                            ->store('kecamatan', 'public');
                    }

                    $profilKecamatan->update($dataKecamatan);
                }
            });

            return $this->success(
                $this->buildResponse($record->fresh()),
                'Profil desa berhasil diperbarui.'
            );
        } catch (\Throwable $e) {
            return $this->error(
                'Gagal memperbarui profil desa: ' . $e->getMessage(),
                null,
                500
            );
        }
    }

    public function deleteProfilDesa(): JsonResponse
    {
        try {
            DB::transaction(function () {
                $profilDesa = RefProfilDesa::query()->first();
                $profilKecamatan = RefKecamatan::query()->first();

                // Delete stored files for ProfilDesa
                if ($profilDesa) {
                    if ($profilDesa->logo && Storage::disk('public')->exists($profilDesa->logo)) {
                        Storage::disk('public')->delete($profilDesa->logo);
                    }
                    if ($profilDesa->peta_pdf && Storage::disk('public')->exists($profilDesa->peta_pdf)) {
                        Storage::disk('public')->delete($profilDesa->peta_pdf);
                    }
                    $profilDesa->delete();
                }

                // Delete stored files for RefKecamatan
                if ($profilKecamatan) {
                    if ($profilKecamatan->foto && Storage::disk('public')->exists($profilKecamatan->foto)) {
                        Storage::disk('public')->delete($profilKecamatan->foto);
                    }
                    if ($profilKecamatan->tanda_tangan && Storage::disk('public')->exists($profilKecamatan->tanda_tangan)) {
                        Storage::disk('public')->delete($profilKecamatan->tanda_tangan);
                    }
                    $profilKecamatan->delete();
                }

                RefProfilDesa::truncate();
                RefKecamatan::truncate();
            });

            return $this->success(
                null,
                'Profil desa berhasil dihapus.'
            );
        } catch (\Throwable $e) {
            return $this->error(
                'Gagal menghapus profil desa: ' . $e->getMessage(),
                null,
                500
            );
        }
    }
}
