<?php

namespace App\Services;

use App\Models\Internship;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class InternshipService
{
    public function getAdminPaginatedList(string $filterStatus = '', string $search = ''): LengthAwarePaginator
    {
        return Internship::with(['intern.internProfile', 'supervisor.supervisorProfile', 'vacancy', 'evaluation'])
            ->when($filterStatus, fn ($q) => $q->where('status', $filterStatus))
            ->when($search, function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->whereHas('intern.internProfile', fn ($sub) => $sub->where('full_name', 'like', "%{$search}%"))
                        ->orWhereHas('intern', fn ($sub) => $sub->where('email', 'like', "%{$search}%"))
                        ->orWhereHas('vacancy', fn ($sub) => $sub->where('title', 'like', "%{$search}%"))
                        ->orWhereHas('supervisor.supervisorProfile', fn ($sub) => $sub->where('full_name', 'like', "%{$search}%"))
                        ->orWhereHas('supervisor', fn ($sub) => $sub->where('email', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(10);
    }

    public function countByStatus(): array
    {
        $rows = Internship::query()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return [
            'total' => array_sum($rows),
            'active' => $rows['active'] ?? 0,
            'completed' => $rows['completed'] ?? 0,
            'terminated' => $rows['terminated'] ?? 0,
        ];
    }

    public function updateStatus(string $id, string $status): Internship
    {
        $internship = Internship::findOrFail($id);
        $internship->update(['status' => $status]);

        return $internship->fresh();
    }

    public function updateDates(string $id, ?string $startDate, ?string $endDate): Internship
    {
        $internship = Internship::findOrFail($id);
        $data = [];
        if ($startDate) {
            $data['actual_start_date'] = $startDate;
        }
        if ($endDate) {
            $data['actual_end_date'] = $endDate;
        }
        $internship->update($data);

        return $internship->fresh();
    }

    public function assignSupervisor(string $internshipId, string $supervisorId): Internship
    {
        $internship = Internship::findOrFail($internshipId);
        $internship->update(['supervisor_id' => $supervisorId]);

        return $internship->fresh();
    }

    public function getSupervisorInterns(string $supervisorId, string $filterStatus = 'active', string $search = ''): LengthAwarePaginator
    {
        return Internship::with(['intern.internProfile', 'vacancy'])
            ->withCount(['logbooks', 'approvedLogbooks'])
            ->where('supervisor_id', $supervisorId)
            ->when($filterStatus, fn ($q) => $q->where('status', $filterStatus))
            ->when($search, function ($q) use ($search) {
                $q->whereHas('intern', function ($q) use ($search) {
                    $q->where('email', 'like', "%{$search}%")
                        ->orWhereHas('internProfile', fn ($q) => $q->where('full_name', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(10);
    }

    public function countUnassignedByStatus(): array
    {
        $rows = Internship::query()
            ->whereNull('supervisor_id')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return [
            'total' => array_sum($rows),
            'active' => $rows['active'] ?? 0,
            'completed' => $rows['completed'] ?? 0,
            'terminated' => $rows['terminated'] ?? 0,
        ];
    }

    public function getSupervisorMappedList(string $filterStatus = 'active', string $search = ''): LengthAwarePaginator
    {
        return Internship::with(['intern.internProfile', 'vacancy'])
            ->whereNull('supervisor_id')
            ->when($filterStatus, fn ($q) => $q->where('status', $filterStatus))
            ->when($search, function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->whereHas('intern.internProfile', fn ($sub) => $sub->where('full_name', 'like', "%{$search}%"))
                        ->orWhereHas('intern', fn ($sub) => $sub->where('email', 'like', "%{$search}%"))
                        ->orWhereHas('vacancy', fn ($sub) => $sub->where('title', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(10);
    }

    public function getSupervisors(): Collection
    {
        return User::where('role', 'supervisor')
            ->where('is_active', true)
            ->with('supervisorProfile')
            ->orderBy('email')
            ->get();
    }
}
