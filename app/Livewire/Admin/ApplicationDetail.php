<?php

namespace App\Livewire\Admin;

use App\Models\Application;
use App\Models\AuditLog;
use App\Notifications\ApplicationNotification;
use App\Services\ApplicationService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts::app', ['title' => 'Review Lamaran'])]
class ApplicationDetail extends Component
{
    public ?string $applicationId = null;

    public string $reviewStatus = '';

    public ?string $rejectionReason = null;

    public ?string $interviewDate = null;

    public ?string $adminNotes = null;

    private ApplicationService $applicationService;

    public function boot(ApplicationService $applicationService): void
    {
        $this->applicationService = $applicationService;
    }

    public function mount(string $id): void
    {
        $this->applicationId = $id;
        $app = Application::findOrFail($id);
        $this->reviewStatus = $app->status;
        $this->rejectionReason = $app->rejection_reason;
        $this->interviewDate = $app->interview_date?->format('Y-m-d\TH:i');
        $this->adminNotes = $app->admin_notes;
    }

    public function updateStatus(): void
    {
        $this->validate([
            'reviewStatus' => 'required|in:under_review,interview_scheduled,accepted,rejected',
            'rejectionReason' => 'required_if:reviewStatus,rejected|string|nullable',
            'interviewDate' => 'nullable|date',
            'adminNotes' => 'nullable|string',
        ]);

        $application = Application::findOrFail($this->applicationId);

        try {
            if ($this->reviewStatus === 'accepted') {
                $this->applicationService->accept($application);
                $application->refresh()->intern->notify(new ApplicationNotification($application, 'decision'));
            } elseif ($this->reviewStatus === 'rejected') {
                $this->applicationService->reject($application, $this->rejectionReason);
                $application->refresh()->intern->notify(new ApplicationNotification($application, 'decision'));
            } else {
                $this->applicationService->updateStatus(
                    $application,
                    $this->reviewStatus,
                    $this->rejectionReason,
                    $this->interviewDate
                );

                if ($this->adminNotes) {
                    $application->update(['admin_notes' => $this->adminNotes]);
                }

                $application->refresh();

                if ($this->reviewStatus === 'interview_scheduled') {
                    $application->intern->notify(new ApplicationNotification($application, 'interview_scheduled'));
                } else {
                    $application->intern->notify(new ApplicationNotification($application, 'status_updated'));
                }
            }
        } catch (\Exception $e) {
            $this->dispatch('toast', message: $e->getMessage(), type: 'error');

            return;
        }

        $this->dispatch('toast', message: 'Status lamaran berhasil diperbarui.', type: 'success');
    }

    public function render()
    {
        $application = Application::with(['intern.internProfile', 'vacancy', 'internship'])
            ->findOrFail($this->applicationId);

        $auditLogs = AuditLog::where('auditable_type', Application::class)
            ->where('auditable_id', $this->applicationId)
            ->with(['user.internProfile', 'user.supervisorProfile'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('livewire.admin.application-detail', compact('application', 'auditLogs'));
    }
}
