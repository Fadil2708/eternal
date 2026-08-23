<?php

namespace App\Livewire\Intern;

use App\Models\Vacancy;
use App\Services\VacancyService;
use Livewire\Component;
use Livewire\WithPagination;

class VacancyList extends Component
{
    use WithPagination;

    public $search = '';

    public $filterDivision = '';

    public $divisions = [];

    private VacancyService $vacancyService;

    public function boot(VacancyService $vacancyService): void
    {
        $this->vacancyService = $vacancyService;
    }

    public function mount(): void
    {
        $this->divisions = Vacancy::where('status', 'open')->distinct()->pluck('division')->toArray();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterDivision(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset('search', 'filterDivision');
    }

    public function render()
    {
        $vacancies = $this->vacancyService->getOpenVacancies($this->search, $this->filterDivision);

        $totalCount = $vacancies->total();
        $divisionCount = count($this->divisions);
        $nearestDeadline = Vacancy::where('status', 'open')
            ->where('application_deadline', '>=', now()->toDateString())
            ->min('application_deadline');

        return view('livewire.intern.vacancy-list', compact('vacancies', 'totalCount', 'divisionCount', 'nearestDeadline'));
    }
}
