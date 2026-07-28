<?php

namespace App\Http\Controllers\Api;

use App\Models\RefProfilDesa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravolt\Indonesia\Models\Village;
use App\Models\RefKecamatan;

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

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'kode' => 'nullable|string|max:20',
            'kode_pos' => 'nullable|string|max:10',
            'alamat' => 'nullable|string|max:500',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'website' => 'nullable|url|max:255',

            'logo' => 'nullable|file|image|max:2048',

            'visi' => 'nullable|string|max:1000',
            'misi' => 'nullable|array|max:20',
            'misi.*' => 'required|string|max:255',

            'deskripsi' => 'nullable|string|max:2000',

            'peta_pdf' => 'nullable|file|mimes:pdf|max:10240',

            'nama_provinsi' => 'nullable|string|max:100',
            'nama_kabupaten' => 'nullable|string|max:100',
            'nama_kecamatan' => 'nullable|string|max:100',
            'nama_desa' => 'nullable|string|max:100',

            'profil_kecamatan' => 'nullable|array',

            'profil_kecamatan.camat' => 'nullable|string|max:100',
            'profil_kecamatan.nip' => 'nullable|string|max:50',
            'profil_kecamatan.telepon' => 'nullable|string|max:20',
            'profil_kecamatan.email' => 'nullable|email|max:100',
            'profil_kecamatan.foto' => 'nullable|file|image|max:2048',
            'profil_kecamatan.tanda_tangan' => 'nullable|file|image|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->error(
                'Validasi gagal.',
                $validator->errors()->toArray(),
                422
            );
        }

        $profilDesa = $this->resolveModel();

        // Only allow one record
        if ($profilDesa->newQuery()->exists()) {
            return $this->error(
                'Profil desa sudah ada. Gunakan endpoint update untuk mengubah data.',
                null,
                409
            );
        }

        // TODO: Wrap the transaction in a DB transaction to ensure both records are created successfully
        $profilDesa = $profilDesa->newQuery()->create(
            $request->only($profilDesa->getFillable())
        );

        $profilKecamatan = RefKecamatan::query()->create(
            $request->input('profil_kecamatan', [])
        );

        return $this->success(
            $this->buildResponse($profilDesa->fresh()),
            'Profil desa berhasil ditambahkan.',
            201
        );
    }

    public function showProfilDesa(): JsonResponse
    {
        $record = $this->resolveModel()
            ->newQuery()
            ->firstOrFail();

        return $this->success($this->buildResponse($record));
    }

    // TODO: Add validator just like in the store() method
    public function updateProfilDesa(Request $request): JsonResponse
    {
        $record = $this->resolveModel()
            ->newQuery()
            ->firstOrFail();

        $data = $request->only($record->getFillable());
        $record->update($data);

        $profilKecamatan = RefKecamatan::query()->first();
        if ($profilKecamatan) {
            $profilKecamatan->update($request->input('profil_kecamatan', []));
        }

        return $this->success(
            $this->buildResponse($record->fresh()),
            'Profil desa berhasil diperbarui.'
        );
    }

    public function deleteProfilDesa(): JsonResponse
    {
        RefProfilDesa::query()->delete();
        RefKecamatan::query()->delete();

        return $this->success(
            null,
            'Profil desa berhasil dihapus.'
        );
    }

    // Method index is disabled
    // public function index(Request $request): JsonResponse
    // {
    //     $record = $this->resolveModel()
    //         ->newQuery()
    //         ->first();

    //     if (!$record) {
    //         return $this->success(null, 'Profil desa belum tersedia.');
    //     }

    //     return $this->success($this->buildResponse($record));
    // }
}
