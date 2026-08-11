<?php

namespace App\Livewire\Supervisor;

use App\Models\Logbook;
use App\Services\LogbookService;
use Livewire\Component;
use Livewire\WithPagination;

class LogbookReview extends Component
{
    use WithPagination;

    public $filterStatus = '';

    public $search = '';

    public bool $showRevisionModal = false;

    public string $revisionNotes = '';

    public ?string $selectedLogbookId = null;

    public array $selectedLogbooks = [];

    public int $totalSubmitted = 0;

    private LogbookService $logbookService;

    public function boot(LogbookService $logbookService): void
    {
        $this->logbookService = $logbookService;
    }

    public function mount(): void
    {
        $this->totalSubmitted = Logbook::whereHas('internship', fn ($q) => $q->where('supervisor_id', auth()->id()))
            ->where('validation_status', 'submitted')->count();
    }

    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function openRevision(string $id): void
    {
        $this->selectedLogbookId = $id;
        $this->revisionNotes = '';
        $this->showRevisionModal = true;
    }

    public function requestRevision(): void
    {
        $this->validate(['revisionNotes' => 'required|string|max:1000']);

        $logbook = Logbook::whereHas('internship', fn ($q) => $q->where('supervisor_id', auth()->id()))
            ->findOrFail($this->selectedLogbookId);
        $logbook->update([
            'validation_status' => 'revision_requested',
            'revision_notes' => $this->revisionNotes,
        ]);

        $this->showRevisionModal = false;
        $this->revisionNotes = '';
        $this->selectedLogbookId = null;
        $this->dispatch('toast', message: 'Revisi berhasil diminta.', type: 'success');
    }

    public function approve(string $id): void
    {
        Logbook::whereHas('internship', fn ($q) => $q->where('supervisor_id', auth()->id()))
            ->where('validation_status', 'submitted')
            ->where('id', $id)
            ->update(['validation_status' => 'approved']);
        $this->dispatch('toast', message: 'Logbook disetujui.', type: 'success');
    }

    public function bulkApprove(): void
    {
        Logbook::whereHas('internship', fn ($q) => $q->where('supervisor_id', auth()->id()))
            ->where('validation_status', 'submitted')
            ->whereIn('id', $this->selectedLogbooks)
            ->update(['validation_status' => 'approved']);
        $this->selectedLogbooks = [];
        $this->dispatch('toast', message: count($this->selectedLogbooks).' logbook disetujui.', type: 'success');
    }

    public function toggleSelectAll(): void
    {
        $ids = Logbook::whereHas('internship', fn ($q) => $q->where('supervisor_id', auth()->id()))
            ->where('validation_status', 'submitted')
            ->pluck('id')
            ->toArray();
        $this->selectedLogbooks = count($this->selectedLogbooks) === count($ids) ? [] : $ids;
    }

    public function render()
    {
        $logbooks = $this->logbookService->getSupervisorPaginatedList(
            auth()->id(),
            $this->filterStatus,
            $this->search
        );

        return view('livewire.supervisor.logbook-review', compact('logbooks'));
    }
}
