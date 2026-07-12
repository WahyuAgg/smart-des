<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Alamat;

use App\Models\Penduduk;

class PendudukController extends CrudController
{
    protected string $modelClass = Penduduk::class;

    protected array $withShow = [
        'alamat',
        'pendidikan',
        'kk',
    ];

    protected array $withUpdate = [
        'alamat',
        'pendidikan',
        'kk',
    ];

    protected array $withStore = [
        'alamat',
        'pendidikan',
        'kk',
    ];

    public function index(Request $request): JsonResponse
    {

        $perPage = $request->input('per_page', $this->perPage);

        $perPage = min($perPage, 100);

        $query = $this->resolveModel()
            ->newQuery()
            ->with($this->withIndex)
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('nama_lengkap', 'like', '%' . $request->search . '%')
                    ->orWhere('nik', 'like', '%' . $request->search . '%');;
            });



        $records = $query->latest()->paginate($perPage);

        $records->through(function ($item) {
            return $item->append($this->appends);
        });

        return $this->success($records);
    }

    public function show(string $id): JsonResponse
    {
        $record = $this->resolveModel()
            ->newQuery()
            ->with($this->withShow)
            ->findOrFail($id);

        $record->append($this->appends);
        return $this->success($record);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $penduduk = $this->resolveModel()
            ->newQuery()
            ->findOrFail($id);



        DB::transaction(function () use ($penduduk, $request) {

            // 1. Update data dasar Penduduk
            $penduduk->update($request->except('alamat_id'));

            // 2. Update Alamat
            if ($request->filled('alamat')) {

                $pendudukLain = Penduduk::where('alamat_id', $penduduk->alamat_id)
                    ->where('id', '!=', $penduduk->id)
                    ->exists();


                if ($pendudukLain) {

                    $alamat = Alamat::create($request->alamat);
                    $penduduk->alamat_id = $alamat->id;
                } else {

                    $alamat = Alamat::where('id', $penduduk->alamat_id)->update($request->alamat);
                }
            }

            $penduduk->save();
        });

        return $this->success(
            $penduduk->fresh($this->withUpdate),
            'Data penduduk berhasil diperbarui.'
        );
    }

    public function store(Request $request): JsonResponse
    {
        $penduduk = DB::transaction(function () use ($request) {

            $alamat = Alamat::create($request->alamat);

            $dataPenduduk = $request->except('alamat');

            $penduduk = Penduduk::create($dataPenduduk);

            $penduduk->alamat_id = $alamat->id;
            $penduduk->save();

            return $penduduk;
        });

        return $this->success(
            $penduduk->fresh($this->withStore),
            'Data penduduk berhasil ditambahkan.',
            201
        );
    }
}
