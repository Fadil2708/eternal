<?php

namespace App\Livewire\Intern;

use App\Models\Application;
use App\Models\Vacancy;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts::app', ['title' => 'Detail Lowongan'])]
class VacancyDetail extends Component
{
    public ?Vacancy $vacancy = null;

    public bool $hasApplied = false;

    public ?string $applicationStatus = null;

    public function mount(string $vacancyId): void
    {
        $this->vacancy = Vacancy::withCount('acceptedApplications')
            ->findOrFail($vacancyId);

        $existing = Application::where('intern_id', auth()->id())
            ->where('vacancy_id', $this->vacancy->id)
            ->first();

        if ($existing) {
            $this->hasApplied = true;
            $this->applicationStatus = $existing->status;
        }
    }

    public function render()
    {
        return view('livewire.intern.vacancy-detail');
    }
}