<?php

namespace App\Services;

use App\Models\Vacancy;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class VacancyService
{
    private const ALLOWED_SORT_FIELDS = ['title', 'division', 'status', 'created_at', 'start_date', 'end_date'];

    private const ALLOWED_SORT_DIRECTIONS = ['asc', 'desc'];

    public function getPaginatedList(string $search = '', string $filterStatus = '', string $sortField = 'created_at', string $sortDirection = 'desc'): LengthAwarePaginator
    {
        $sortField = in_array($sortField, self::ALLOWED_SORT_FIELDS) ? $sortField : 'created_at';
        $sortDirection = in_array($sortDirection, self::ALLOWED_SORT_DIRECTIONS) ? $sortDirection : 'desc';

        return Vacancy::with('creator')
            ->withCount('acceptedApplications')
            ->when($search, fn ($q) => $q->where(function ($q) use ($search) {
                $q->where('title', 'like', '%'.$search.'%')
                    ->orWhere('division', 'like', '%'.$search.'%');
            }))
            ->when($filterStatus, fn ($q) => $q->where('status', $filterStatus))
            ->orderBy($sortField, $sortDirection)
            ->paginate(10);
    }

    public function countByStatus(): array
    {
        $rows = Vacancy::query()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return [
            'total' => array_sum($rows),
            'draft' => $rows['draft'] ?? 0,
            'open' => $rows['open'] ?? 0,
            'closed' => $rows['closed'] ?? 0,
        ];
    }

    public function delete(Vacancy $vacancy): bool
    {
        if ($vacancy->applications()->exists()) {
            return false;
        }

        $vacancy->delete();

        return true;
    }

    public function create(array $data, string $createdBy): Vacancy
    {
        $data['created_by'] = $createdBy;

        return Vacancy::create($data);
    }

    public function update(Vacancy $vacancy, array $data): Vacancy
    {
        $vacancy->update($data);

        return $vacancy->fresh();
    }

    public function getOpenVacancies(string $search = '', string $filterDivision = ''): LengthAwarePaginator
    {
        return Vacancy::withCount('acceptedApplications')
            ->where('status', 'open')
            ->where('application_deadline', '>=', now()->format('Y-m-d'))
            ->when($search, fn ($q) => $q->where(function ($q) use ($search) {
                $q->where('title', 'like', '%'.$search.'%')
                    ->orWhere('division', 'like', '%'.$search.'%');
            }))
            ->when($filterDivision, fn ($q) => $q->where('division', $filterDivision))
            ->orderBy('created_at', 'desc')
            ->paginate(9);
    }
}
