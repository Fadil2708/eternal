<?php

namespace App\Livewire\Admin;

use App\Models\FinalReport;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ReportList extends Component
{
    use WithPagination;

    public $filterStatus = '';

    public $search = '';

    public array $statusCounts = [];

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
        $this->statusCounts = FinalReport::query()
            ->select('supervisor_approval', DB::raw('count(*) as total'))
            ->groupBy('supervisor_approval')
            ->pluck('total', 'supervisor_approval')
            ->toArray();
        $this->statusCounts['total'] = array_sum($this->statusCounts);

        $reports = FinalReport::with(['intern.internProfile', 'internship.vacancy'])
            ->when($this->search, function ($q) {
                $q->whereHas('intern', function ($q2) {
                    $q2->where('email', 'like', "%{$this->search}%")
                        ->orWhereHas('internProfile', function ($q3) {
                            $q3->where('full_name', 'like', "%{$this->search}%");
                        });
                });
            })
            ->when($this->filterStatus, fn ($q) => $q->where('supervisor_approval', $this->filterStatus))
            ->latest('submitted_at')
            ->paginate(10);

        return view('livewire.admin.report-list', compact('reports'));
    }
}
