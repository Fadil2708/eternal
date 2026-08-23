<?php

namespace App\Livewire\Admin;

use App\Models\Evaluation;
use App\Services\EvaluationService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class EvaluationList extends Component
{
    use WithPagination;

    public $filterGrade = '';

    public $search = '';

    public array $gradeCounts = [];

    private EvaluationService $evaluationService;

    public function boot(EvaluationService $evaluationService): void
    {
        $this->evaluationService = $evaluationService;
    }

    public function updatingFilterGrade(): void
    {
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->gradeCounts = Evaluation::query()
            ->select('grade', DB::raw('count(*) as total'))
            ->groupBy('grade')
            ->pluck('total', 'grade')
            ->toArray();
        $this->gradeCounts['total'] = array_sum($this->gradeCounts);

        $evaluations = Evaluation::with(['internship.intern.internProfile', 'internship.vacancy', 'supervisor.supervisorProfile'])
            ->when($this->search, function ($q) {
                $q->whereHas('internship.intern', function ($q2) {
                    $q2->where('email', 'like', "%{$this->search}%")
                        ->orWhereHas('internProfile', function ($q3) {
                            $q3->where('full_name', 'like', "%{$this->search}%");
                        });
                });
            })
            ->when($this->filterGrade, fn ($q) => $q->where('grade', $this->filterGrade))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.evaluation-list', compact('evaluations'));
    }
}
