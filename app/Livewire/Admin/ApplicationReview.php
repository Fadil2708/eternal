<?php

namespace App\Livewire\Admin;

use App\Models\Application;
use App\Models\Vacancy;
use App\Services\ApplicationService;
use Livewire\Component;
use Livewire\WithPagination;

class ApplicationReview extends Component
{
    use WithPagination;

    public string $filterStatus = '';

    public string $filterVacancy = '';

    public array $statusCounts = [];

    private ApplicationService $applicationService;

    public function boot(ApplicationService $applicationService): void
    {
        $this->applicationService = $applicationService;
    }

    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }

    public function updatingFilterVacancy(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $applications = Application::with(['intern.internProfile', 'vacancy', 'internship'])
            ->when($this->filterStatus, fn ($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterVacancy, fn ($q) => $q->where('vacancy_id', $this->filterVacancy))
            ->orderBy('applied_at', 'desc')
            ->paginate(15);

        $vacancies = Vacancy::select('id', 'title')->get();
        $this->statusCounts = $this->applicationService->countByStatus();

        return view('livewire.admin.application-review', compact('applications', 'vacancies'));
    }
}
