<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends ApiController
{
    protected int $defaultPerPage = 15;
    protected int $maxPerPage = 100;

    /**
     * Display a paginated list of users.
     * Supports search, role filter, and pagination.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min((int) $request->input('per_page', $this->defaultPerPage), $this->maxPerPage);

        $query = User::query()->with('roles');

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role (Spatie)
        if ($request->filled('role')) {
            $query->role($request->input('role'));
        }

        $records = $query->latest()->paginate($perPage);

        // Append role names to each user
        $records->through(function ($user) {
            $user->append('role_name');
            return $user;
        });

        return $this->success($records);
    }

    /**
     * Store a newly created user.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $result = DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password')),
                    'is_active' => $request->boolean('is_active', true),
                ]);

                // Assign role via Spatie
                $user->syncRoles($request->input('role'));

                return $user->load('roles');
            });

            $result->append('role_name');

            return $this->success(
                $result,
                'User berhasil ditambahkan.',
                201
            );
        } catch (\Throwable $e) {
            return $this->error(
                'Gagal menyimpan user: ' . $e->getMessage(),
                null,
                500
            );
        }
    }

    /**
     * Display the specified user.
     */
    public function show(int $id): JsonResponse
    {
        $user = User::with('roles')->findOrFail($id);
        $user->append('role_name');

        return $this->success($user);
    }

    /**
     * Update the specified user.
     */
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $user = User::findOrFail($id);

        try {
            DB::transaction(function () use ($request, $user) {
                $data = [];

                if ($request->filled('name')) {
                    $data['name'] = $request->input('name');
                }

                if ($request->filled('email')) {
                    $data['email'] = $request->input('email');
                }

                if ($request->filled('password')) {
                    $data['password'] = Hash::make($request->input('password'));
                }

                if ($request->has('is_active')) {
                    // Business rule: cannot deactivate own account
                    if (!$request->boolean('is_active') && (int) $user->id === (int) $request->user()->id) {
                        throw new \RuntimeException('Anda tidak dapat menonaktifkan akun sendiri.');
                    }

                    // Business rule: cannot deactivate the last admin
                    if (!$request->boolean('is_active') && $user->hasRole('admin')) {
                        $this->ensureLastAdminNotDemoted($user, 'nonaktifkan');
                    }

                    $data['is_active'] = $request->boolean('is_active');
                }

                $user->update($data);

                // Sync role if provided
                if ($request->filled('role')) {
                    $newRole = $request->input('role');

                    // Business rule: cannot demote the last admin
                    if ($user->hasRole('admin') && $newRole !== 'admin') {
                        $this->ensureLastAdminNotDemoted($user, 'turunkan role');
                    }

                    $user->syncRoles($newRole);
                }
            });

            $user->fresh()->load('roles');
            $user->append('role_name');

            return $this->success(
                $user,
                'User berhasil diperbarui.'
            );
        } catch (\RuntimeException $e) {
            return $this->error($e->getMessage(), null, 422);
        } catch (\Throwable $e) {
            return $this->error(
                'Gagal memperbarui user: ' . $e->getMessage(),
                null,
                500
            );
        }
    }

    /**
     * Remove the specified user.
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $user = User::findOrFail($id);

        // Business rule: cannot delete own account
        if ((int) $id === (int) $request->user()->id) {
            return $this->error('Anda tidak dapat menghapus akun sendiri.', null, 422);
        }

        // Business rule: cannot delete the last admin
        if ($user->hasRole('admin')) {
            $adminCount = User::role('admin')->count();
            if ($adminCount <= 1) {
                return $this->error(
                    'Tidak dapat menghapus admin terakhir. Harus ada setidaknya satu admin yang aktif.',
                    null,
                    422
                );
            }
        }

        try {
            DB::transaction(function () use ($user) {
                $user->syncRoles([]);
                $user->delete();
            });

            return $this->success(null, 'User berhasil dihapus.');
        } catch (\Throwable $e) {
            return $this->error(
                'Gagal menghapus user: ' . $e->getMessage(),
                null,
                500
            );
        }
    }

    /**
     * Toggle user active/inactive status.
     */
    public function toggleActive(Request $request, int $id): JsonResponse
    {
        $user = User::findOrFail($id);

        // Business rule: cannot deactivate own account
        if ((int) $id === (int) $request->user()->id) {
            return $this->error('Anda tidak dapat menonaktifkan akun sendiri.', null, 422);
        }

        // Business rule: cannot deactivate the last admin
        if ($user->hasRole('admin') && $user->is_active) {
            $adminCount = User::role('admin')->count();
            if ($adminCount <= 1) {
                return $this->error(
                    'Tidak dapat menonaktifkan admin terakhir. Harus ada setidaknya satu admin yang aktif.',
                    null,
                    422
                );
            }
        }

        try {
            $user->update(['is_active' => !$user->is_active]);

            return $this->success(
                $user->fresh()->load('roles'),
                $user->is_active ? 'User berhasil diaktifkan.' : 'User berhasil dinonaktifkan.'
            );
        } catch (\Throwable $e) {
            return $this->error(
                'Gagal mengubah status user: ' . $e->getMessage(),
                null,
                500
            );
        }
    }

    /**
     * Ensure the user being demoted/deactivated is not the last admin.
     *
     * @throws \RuntimeException
     */
    private function ensureLastAdminNotDemoted(User $user, string $action): void
    {
        $adminCount = User::role('admin')->count();
        if ($adminCount <= 1) {
            throw new \RuntimeException(
                "Tidak dapat {$action} admin terakhir. Harus ada setidaknya satu admin yang aktif."
            );
        }
    }
}
