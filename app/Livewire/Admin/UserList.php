<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Services\UserService;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;

    public string $search = '';

    public string $filterRole = '';

    public array $roleCounts = [];

    public ?string $confirmingDeactivateId = null;

    public ?string $confirmingDeleteId = null;

    private UserService $userService;

    public function boot(UserService $userService): void
    {
        $this->userService = $userService;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterRole(): void
    {
        $this->resetPage();
    }

    public function confirmDeactivate(string $id): void
    {
        $this->confirmingDeactivateId = $id;
    }

    public function deactivate(): void
    {
        $user = User::findOrFail($this->confirmingDeactivateId);
        $active = $this->userService->toggleActive($user);
        $this->dispatch('toast', message: $active ? 'Pengguna diaktifkan.' : 'Pengguna dinonaktifkan.', type: 'success');
        $this->confirmingDeactivateId = null;
    }

    public function confirmDelete(string $id): void
    {
        $this->confirmingDeleteId = $id;
    }

    public function delete(): void
    {
        $user = User::findOrFail($this->confirmingDeleteId);

        try {
            $this->userService->delete($user);
            $this->dispatch('toast', message: 'Pengguna berhasil dihapus.', type: 'success');
        } catch (\Exception $e) {
            $this->dispatch('toast', message: $e->getMessage(), type: 'error');
        }

        $this->confirmingDeleteId = null;
    }

    public function render()
    {
        $users = $this->userService->getPaginatedList($this->search, $this->filterRole);
        $this->roleCounts = $this->userService->countByRole();

        return view('livewire.admin.user-list', compact('users'));
    }
}
