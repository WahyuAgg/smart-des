<?php

namespace App\Http\Controllers\Api;

use App\Models\RefProfilDesa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravolt\Indonesia\Models\Village;

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
        'sekdes',
        'kaur_tu',
        'kaur_keu',
        'kaur_per',
        'kasi_pem',
        'kasi_kes',
        'kasi_pel',
        'kepala_dusun',
        'staf_adm',
        'staf_keu',
        'staf_per',
        'staf_pel',
        'operator_desa',
        'bendahara',
        'pengelola_arsip',
        'staf_umum',
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

    public function show(string $id): JsonResponse
    {
        $record = $this->resolveModel()
            ->newQuery()
            ->findOrFail($id);

        return $this->success($this->buildResponse($record));
    }

    public function index(Request $request): JsonResponse
    {
        $record = $this->resolveModel()
            ->newQuery()
            ->first();

        if (!$record) {
            return $this->success(null, 'Profil desa belum tersedia.');
        }

        return $this->success($this->buildResponse($record));
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $record = $this->resolveModel()
            ->newQuery()
            ->findOrFail($id);

        $data = $request->only($record->getFillable());
        $record->update($data);

        return $this->success(
            $this->buildResponse($record->fresh()),
            'Profil desa berhasil diperbarui.'
        );
    }
}
