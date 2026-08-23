<?php

namespace App\Livewire\Admin;

use App\Models\Vacancy;
use App\Services\VacancyService;
use Livewire\Component;
use Livewire\WithPagination;

class VacancyList extends Component
{
    use WithPagination;

    public $search = '';

    public $filterStatus = '';

    public $sortField = 'created_at';

    public $sortDirection = 'desc';

    public array $statusCounts = [];

    private VacancyService $vacancyService;

    public function boot(VacancyService $vacancyService): void
    {
        $this->vacancyService = $vacancyService;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function deleteVacancy(string $id): void
    {
        $vacancy = Vacancy::findOrFail($id);

        if (! $this->vacancyService->delete($vacancy)) {
            $this->dispatch('toast', message: 'Lowongan tidak bisa dihapus karena sudah memiliki pelamar.', type: 'error');

            return;
        }

        $this->dispatch('toast', message: 'Lowongan berhasil dihapus.', type: 'success');
    }

    public function render()
    {
        $vacancies = $this->vacancyService->getPaginatedList(
            $this->search,
            $this->filterStatus,
            $this->sortField,
            $this->sortDirection
        );
        $this->statusCounts = $this->vacancyService->countByStatus();

        return view('livewire.admin.vacancy-list', compact('vacancies'));
    }
}
