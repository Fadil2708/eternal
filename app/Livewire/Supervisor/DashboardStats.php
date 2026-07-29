<?php

namespace App\Livewire\Supervisor;

use App\Services\DashboardService;
use Livewire\Component;

class DashboardStats extends Component
{
    public int $totalInterns = 0;
    public int $pendingLogbooks = 0;
    public int $pendingReports = 0;
    public int $pendingEvaluations = 0;
    public int $approvedLogbooks = 0;
    public int $totalLogbooks = 0;
    public int $revisionLogbooks = 0;
    public $activeInternships;

    public function mount(DashboardService $dashboardService): void
    {
        $stats = $dashboardService->getSupervisorStats(auth()->id());

        $this->totalInterns = $stats['totalInterns'];
        $this->pendingLogbooks = $stats['pendingLogbooks'];
        $this->pendingReports = $stats['pendingReports'];
        $this->pendingEvaluations = $stats['pendingEvaluations'];
        $this->activeInternships = $stats['activeInternships'];

        $userId = auth()->id();
        $this->totalLogbooks = \App\Models\Logbook::whereHas('internship', fn($q) => $q->where('supervisor_id', $userId))->count();
        $this->approvedLogbooks = \App\Models\Logbook::whereHas('internship', fn($q) => $q->where('supervisor_id', $userId))
            ->where('validation_status', 'approved')->count();
        $this->revisionLogbooks = \App\Models\Logbook::whereHas('internship', fn($q) => $q->where('supervisor_id', $userId))
            ->where('validation_status', 'revision_requested')->count();
    }

    public function render()
    {
        return view('livewire.supervisor.dashboard-stats');
    }
}