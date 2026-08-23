<?php

namespace App\Livewire\Admin;

use App\Models\Certificate;
use App\Models\Internship;
use App\Jobs\GenerateCertificatePdfJob;
use App\Notifications\CertificateNotification;
use App\Services\CertificateService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class CertificateList extends Component
{
    use WithPagination;

    public $search = '';

    public $filterGrade = '';

    public $confirmingIssueId = null;

    public array $gradeCounts = [];

    private CertificateService $certificateService;

    public function boot(CertificateService $certificateService): void
    {
        $this->certificateService = $certificateService;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterGrade(): void
    {
        $this->resetPage();
    }

    public function confirmIssue(string $id): void
    {
        $this->confirmingIssueId = $id;
    }

    public function issue(): void
    {
        $internship = Internship::with('evaluation')->where('status', 'completed')->findOrFail($this->confirmingIssueId);

        try {
            $certificate = $this->certificateService->issue($internship, auth()->id());
            dispatch(new GenerateCertificatePdfJob($certificate));
            $internship->intern->notify(new CertificateNotification($certificate));
            $this->dispatch('toast', message: 'Sertifikat berhasil diterbitkan.', type: 'success');
        } catch (\Exception $e) {
            $this->dispatch('toast', message: $e->getMessage(), type: 'error');
        }

        $this->confirmingIssueId = null;
    }

    public function render()
    {
        $this->gradeCounts = Certificate::query()
            ->select('grade', DB::raw('count(*) as total'))
            ->groupBy('grade')
            ->pluck('total', 'grade')
            ->toArray();
        $this->gradeCounts['total'] = array_sum($this->gradeCounts);

        $certificates = Certificate::with(['intern.internProfile', 'issuedBy'])
            ->when($this->search, fn ($q) => $q->whereHas('intern.internProfile', fn ($p) => $p->where('full_name', 'like', '%'.$this->search.'%')
            ))
            ->when($this->filterGrade, fn ($q) => $q->where('grade', $this->filterGrade))
            ->latest()
            ->paginate(10);

        $completedInternships = Internship::with(['intern.internProfile', 'vacancy', 'evaluation', 'certificate'])
            ->where('status', 'completed')
            ->whereDoesntHave('certificate')
            ->paginate(10);

        return view('livewire.admin.certificate-list', compact('certificates', 'completedInternships'));
    }
}
