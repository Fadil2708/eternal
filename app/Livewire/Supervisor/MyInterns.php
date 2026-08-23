<?php

namespace App\Livewire\Supervisor;

use App\Services\InternshipService;
use Livewire\Component;
use Livewire\WithPagination;

class MyInterns extends Component
{
    use WithPagination;

    public $filterStatus = 'active';

    public $search = '';

    private InternshipService $internshipService;

    public function boot(InternshipService $internshipService): void
    {
        $this->internshipService = $internshipService;
    }

    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $internships = $this->internshipService->getSupervisorInterns(auth()->id(), $this->filterStatus, $this->search);

        return view('livewire.supervisor.my-interns', compact('internships'));
    }
}
