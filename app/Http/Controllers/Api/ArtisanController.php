<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Output\BufferedOutput;

class ArtisanController extends ApiController
{
    /**
     * Daftar perintah artisan yang diperbolehkan untuk dijalankan melalui API
     * Untuk keamanan, batasi hanya perintah-perintah tertentu
     */
    private array $allowedCommands = [
        'cache:clear',
        'config:clear',
        'config:cache',
        'route:clear',
        'route:cache',
        'view:clear',
        'view:cache',
        'optimize',
        'optimize:clear',
        'storage:link',
        'queue:work',
        'queue:restart',
        'schedule:run',
        'migrate',
        'migrate:status',
        'migrate:rollback',
        'migrate:fresh',
        'migrate:refresh',
        'db:seed',
        'backup:run',
    ];

    /**
     * Mendapatkan daftar perintah artisan yang tersedia
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        return $this->success([
            'commands' => $this->allowedCommands,
        ], 'Daftar perintah artisan yang tersedia');
    }

    /**
     * Menjalankan perintah artisan
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function execute(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'command' => 'required|string',
            'parameters' => 'array',
        ]);

        if ($validator->fails()) {
            return $this->error(
                'Validasi gagal',
                $validator->errors(),
                422
            );
        }

        $command = $request->input('command');
        $parameters = $request->input('parameters', []);

        // Validasi apakah command diperbolehkan
        if (!in_array($command, $this->allowedCommands)) {
            return $this->error(
                'Perintah tidak diperbolehkan',
                [
                    'command' => $command,
                    'allowed_commands' => $this->allowedCommands,
                ],
                403
            );
        }

        try {
            // Gunakan BufferedOutput untuk menangkap output
            $output = new BufferedOutput();

            // Jalankan perintah artisan
            $exitCode = Artisan::call($command, $parameters, $output);

            // Ambil output sebagai string
            $outputContent = $output->fetch();

            return $this->success([
                'command' => $command,
                'parameters' => $parameters,
                'exit_code' => $exitCode,
                'output' => $outputContent,
                'success' => $exitCode === 0,
            ], $exitCode === 0 ? 'Perintah berhasil dijalankan' : 'Perintah selesai dengan error');
        } catch (\Exception $e) {
            return $this->error(
                'Gagal menjalankan perintah',
                [
                    'command' => $command,
                    'error' => $e->getMessage(),
                ],
                500
            );
        }
    }

    /**
     * Menjalankan cache:clear
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cacheClear()
    {
        try {
            Artisan::call('cache:clear');

            return $this->success(
                ['output' => Artisan::output()],
                'Cache berhasil dibersihkan'
            );
        } catch (\Exception $e) {
            return $this->error(
                'Gagal membersihkan cache',
                ['error' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Menjalankan optimize
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function optimize()
    {
        try {
            Artisan::call('optimize');

            return $this->success(
                ['output' => Artisan::output()],
                'Aplikasi berhasil dioptimasi'
            );
        } catch (\Exception $e) {
            return $this->error(
                'Gagal mengoptimasi aplikasi',
                ['error' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Menjalankan optimize:clear
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function optimizeClear()
    {
        try {
            Artisan::call('optimize:clear');

            return $this->success(
                ['output' => Artisan::output()],
                'Cache optimasi berhasil dibersihkan'
            );
        } catch (\Exception $e) {
            return $this->error(
                'Gagal membersihkan cache optimasi',
                ['error' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Menjalankan storage:link
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function storageLink()
    {
        try {
            Artisan::call('storage:link');

            return $this->success(
                ['output' => Artisan::output()],
                'Storage link berhasil dibuat'
            );
        } catch (\Exception $e) {
            return $this->error(
                'Gagal membuat storage link',
                ['error' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Menjalankan migrate
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function migrate()
    {
        try {
            $output = new BufferedOutput();
            Artisan::call('migrate', ['--force' => true], $output);

            return $this->success(
                ['output' => $output->fetch()],
                'Migrasi database berhasil dijalankan'
            );
        } catch (\Exception $e) {
            return $this->error(
                'Gagal menjalankan migrasi',
                ['error' => $e->getMessage()],
                500
            );
        }
    }
}