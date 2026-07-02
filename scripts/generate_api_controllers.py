from pathlib import Path

root = Path(r'c:\agg\projects\KKN\web_desa')
api_dir = root / 'app' / 'Http' / 'Controllers' / 'Api'
models = [
    'Alamat',
    'InvBarang',
    'InvDetailPeminjaman',
    'InvKategoriBarang',
    'InvLokasi',
    'InvPeminjaman',
    'Kk',
    'Pekerjaan',
    'Pendidikan',
    'Penduduk',
    'RefDusun',
    'RefJabatanPerangkat',
    'RefPerangkatDesa',
    'RefProfilDesa',
    'RefRt',
    'RefRw',
    'SrtJenisSurat',
    'SrtJenisSuratField',
    'SrtKategoriSurat',
    'SrtMasterFieldSurat',
    'SrtPengajuanSurat',
    'User',
]
for model in models:
    file_path = api_dir / f'{model}Controller.php'
    file_path.write_text(
        f'''<?php

namespace App\\Http\\Controllers\\Api;

use App\\Models\\{model};

class {model}Controller extends CrudController
{{
    protected string $modelClass = {model}::class;
}}
''',
        encoding='utf-8',
    )
print(f'created {len(models)} controllers')
