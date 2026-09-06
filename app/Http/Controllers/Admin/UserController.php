<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly UserService $userService
    ) {}

    public function index(): JsonResponse
    {
        $users = User::with(['internProfile', 'supervisorProfile'])
            ->paginate(15);

        return $this->success(
            UserResource::collection($users),
            'Daftar pengguna.',
            meta: [
                'current_page' => $users->currentPage(),
                'total' => $users->total(),
            ]
        );
    }

    public function store(CreateUserRequest $request): JsonResponse
    {
        $user = DB::transaction(function () use ($request) {
            $user = User::create([
                'id' => (string) Str::uuid(),
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'is_active' => $request->boolean('is_active', true),
            ]);

            if ($request->role === 'intern') {
                $user->internProfile()->create(['id' => (string) Str::uuid()]);
            } elseif ($request->role === 'supervisor') {
                $user->supervisorProfile()->create(['id' => (string) Str::uuid()]);
            }

            return $user;
        });

        return $this->success(
            new UserResource($user->load(['internProfile', 'supervisorProfile'])),
            'Pengguna berhasil dibuat.',
            201
        );
    }

    public function show(string $id): JsonResponse
    {
        $user = User::with(['internProfile', 'supervisorProfile'])
            ->findOrFail($id);

        return $this->success(new UserResource($user), 'Detail pengguna.');
    }

    public function destroy(string $id): JsonResponse
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return $this->error('Tidak dapat menghapus akun sendiri.', 422);
        }

        try {
            $this->userService->delete($user);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 422);
        }

        return $this->success(message: 'Pengguna berhasil dihapus.');
    }

    public function update(UpdateUserRequest $request, string $id): JsonResponse
    {
        $user = User::findOrFail($id);

        $data = $request->only(['email', 'role', 'is_active']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return $this->success(
            new UserResource($user->fresh()->load(['internProfile', 'supervisorProfile'])),
            'Pengguna berhasil diperbarui.'
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => false]);

        return $this->success(null, 'Pengguna berhasil dinonaktifkan.');
    }
}
