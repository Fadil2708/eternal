<?php

namespace App\Livewire\Intern;

use App\Models\Application;
use Livewire\Component;
use Livewire\WithPagination;

class MyApplications extends Component
{
    use WithPagination;

    public string $filterStatus = '';

    public function updatingFilterStatus(): void { $this->resetPage(); }

    public function render()
    {
        $applications = Application::with(['vacancy', 'internship'])
            ->where('intern_id', auth()->id())
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->orderBy('applied_at', 'desc')
            ->paginate(10);

        return view('livewire.intern.my-applications', compact('applications'));
    }
}