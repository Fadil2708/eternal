<?php

namespace App\Services;

use App\Models\Internship;
use App\Models\Logbook;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class LogbookService
{
    private const TRANSITIONS = [
        'draft' => ['submitted'],
        'submitted' => ['approved', 'revision_requested'],
        'revision_requested' => ['submitted'],
        'approved' => [],
    ];

    public function getAdminPaginatedList(string $search = '', string $filterStatus = ''): LengthAwarePaginator
    {
        return Logbook::with(['intern.internProfile', 'internship.vacancy'])
            ->when($search, fn ($q) => $q->whereHas('intern.internProfile', fn ($p) => $p->where('full_name', 'like', '%'.$search.'%')
            ))
            ->when($filterStatus, fn ($q) => $q->where('validation_status', $filterStatus))
            ->latest('activity_date')
            ->paginate(15);
    }

    public function getSupervisorPaginatedList(string $supervisorId, string $filterStatus = '', string $search = ''): LengthAwarePaginator
    {
        return Logbook::with(['intern.internProfile', 'internship.vacancy'])
            ->whereHas('internship', fn (Builder $q) => $q->where('supervisor_id', $supervisorId))
            ->when($search, fn ($q) => $q->whereHas('intern.internProfile', fn ($p) => $p->where('full_name', 'like', '%'.$search.'%')
            ))
            ->when($filterStatus, fn ($q) => $q->where('validation_status', $filterStatus))
            ->latest('activity_date')
            ->paginate(15);
    }

    public function create(string $internshipId, User $intern, array $data): Logbook
    {
        $internship = Internship::where('intern_id', $intern->id)
            ->where('status', 'active')
            ->firstOrFail();

        $data['internship_id'] = $internshipId;
        $data['intern_id'] = $intern->id;
        $data['validation_status'] = 'draft';

        return Logbook::create($data);
    }

    public function update(Logbook $logbook, array $data, User $intern): void
    {
        if ($logbook->intern_id !== $intern->id) {
            throw new \Exception('Unauthorized.');
        }

        $allowedStates = ['draft', 'revision_requested'];
        if (! in_array($logbook->validation_status, $allowedStates)) {
            throw new \Exception('Logbook sudah tidak bisa diedit.');
        }

        $logbook->update($data);
    }

    public function submit(Logbook $logbook, User $intern): void
    {
        if ($logbook->intern_id !== $intern->id) {
            throw new \Exception('Unauthorized.');
        }

        if (! in_array('submitted', self::TRANSITIONS[$logbook->validation_status] ?? [])) {
            throw new \Exception('Logbook sudah tidak bisa dikirim.');
        }

        $logbook->update(['validation_status' => 'submitted']);
    }

    public function review(Logbook $logbook, User $supervisor, string $action, ?string $notes): Logbook
    {
        if ($logbook->internship?->supervisor_id !== $supervisor->id) {
            throw new \Exception('Unauthorized.');
        }

        if (! in_array($action, ['approved', 'revision_requested'])) {
            throw new \Exception('Aksi review tidak valid.');
        }

        if (! in_array($action, self::TRANSITIONS[$logbook->validation_status] ?? [])) {
            throw new \Exception('Logbook sudah tidak bisa direview.');
        }

        $logbook->update([
            'validation_status' => $action,
            'supervisor_notes' => $notes,
        ]);

        return $logbook;
    }

    public function validateTransition(Logbook $logbook, string $newStatus): void
    {
        if (! in_array($newStatus, self::TRANSITIONS[$logbook->validation_status] ?? [])) {
            throw new \Exception('Status transisi tidak valid.');
        }
    }

    public function getInternPaginatedList(string $internId): LengthAwarePaginator
    {
        return Logbook::where('intern_id', $internId)
            ->orderBy('activity_date', 'desc')
            ->paginate(10);
    }
}
