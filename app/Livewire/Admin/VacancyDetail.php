<?php

namespace App\Livewire\Admin;

use App\Models\Application;
use App\Models\Vacancy;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts::app', ['title' => 'Detail Lowongan'])]
class VacancyDetail extends Component
{
    public ?Vacancy $vacancy = null;

    public string $filterStatus = '';

    public array $statusCounts = [];

    public function mount(string $vacancyId): void
    {
        $this->vacancy = Vacancy::withCount('acceptedApplications')
            ->with('applications.intern.internProfile')
            ->findOrFail($vacancyId);

        $this->statusCounts = [
            'all'           => $this->vacancy->applications()->count(),
            'submitted'     => $this->vacancy->applications()->where('status', 'submitted')->count(),
            'under_review'  => $this->vacancy->applications()->where('status', 'under_review')->count(),
            'interview'     => $this->vacancy->applications()->where('status', 'interview_scheduled')->count(),
            'accepted'      => $this->vacancy->applications()->where('status', 'accepted')->count(),
        ];
    }

    public function getApplicationsProperty()
    {
        return $this->vacancy->applications()
            ->with('intern.internProfile')
            ->when($this->filterStatus !== '', function ($q) {
                if ($this->filterStatus === 'active') {
                    $q->whereIn('status', ['submitted', 'under_review', 'interview_scheduled']);
                } elseif ($this->filterStatus === 'accepted') {
                    $q->where('status', 'accepted');
                }
            })
            ->orderBy('applied_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.vacancy-detail');
    }
}
