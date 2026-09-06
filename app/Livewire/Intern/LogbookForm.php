<?php

namespace App\Livewire\Intern;

use App\Models\Internship;
use App\Models\Logbook;
use App\Services\LogbookService;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts::app', ['title' => 'Logbook'])]
class LogbookForm extends Component
{
    public ?string $logbookId = null;

    public string $activity_date = '';

    public string $activities = '';

    public string $output = '';

    public string $attendanceType = 'hadir';

    public bool $hasActiveInternship = false;

    public string $validationStatus = 'draft';

    private LogbookService $logbookService;

    public function boot(LogbookService $logbookService): void
    {
        $this->logbookService = $logbookService;
    }

    protected $rules = [
        'activity_date' => 'required|date',
        'attendanceType' => 'required|in:hadir,sakit,izin',
        'activities' => 'required_if:attendanceType,hadir|nullable|string',
        'output' => 'required_if:attendanceType,hadir|nullable|string',
    ];

    public function mount(?string $id = null): void
    {
        if ($id) {
            $this->edit($id);
        } else {
            $this->activity_date = now()->format('Y-m-d');
            $this->attendanceType = 'hadir';
        }

        $this->checkActiveInternship();
    }

    public function checkActiveInternship(): void
    {
        $internship = Internship::where('intern_id', auth()->id())
            ->where('status', 'active')
            ->first();

        $this->hasActiveInternship = $internship !== null;
    }

    public function edit(string $id): void
    {
        $logbook = Logbook::where('intern_id', auth()->id())->findOrFail($id);
        $this->logbookId = $logbook->id;
        $this->activity_date = $logbook->activity_date->format('Y-m-d');
        $this->activities = $logbook->activities ?? '';
        $this->output = $logbook->output ?? '';
        $this->attendanceType = $logbook->attendance_type ?? 'hadir';
        $this->validationStatus = $logbook->validation_status;
    }

    public function saveAsDraft(): void
    {
        $this->save('draft');
    }

    public function submit(): void
    {
        $this->save('submitted');
    }

    private function save(string $status): void
    {
        $this->validate();

        $internship = Internship::where('intern_id', auth()->id())
            ->where('status', 'active')
            ->firstOrFail();

        try {
            $data = [
                'activity_date' => $this->activity_date,
                'activities' => $this->activities,
                'output' => $this->output,
                'attendance_type' => $this->attendanceType,
            ];

            if ($this->logbookId) {
                $logbook = Logbook::where('intern_id', auth()->id())->findOrFail($this->logbookId);
                $this->logbookService->update($logbook, $data + ['validation_status' => $status], auth()->user());
                $this->dispatch('toast', message: 'Logbook berhasil diperbarui.', type: 'success');
            } else {
                $this->logbookService->create($internship->id, auth()->user(), $data + ['validation_status' => $status]);
                $this->dispatch('toast', message: 'Logbook berhasil disimpan.', type: 'success');
            }

            $this->redirect(route('intern.logbooks'));
        } catch (\Exception $e) {
            Log::error('Logbook save failed: '.$e->getMessage());
            $this->dispatch('toast', message: 'Gagal menyimpan logbook: '.$e->getMessage(), type: 'error');
        }
    }

    public function resetForm(): void
    {
        $this->reset(['logbookId', 'activity_date', 'activities', 'output', 'validationStatus', 'attendanceType']);
        $this->activity_date = now()->format('Y-m-d');
        $this->attendanceType = 'hadir';
        $this->validationStatus = 'draft';
    }

    public function render()
    {
        return view('livewire.intern.logbook-form');
    }
}
