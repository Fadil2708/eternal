<?php

namespace App\Services;

use App\Models\Skill;
use Illuminate\Pagination\LengthAwarePaginator;

class SkillService
{
    public function getPaginatedList(string $search = ''): LengthAwarePaginator
    {
        return Skill::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(10);
    }

    public function create(array $data): Skill
    {
        return Skill::create($data);
    }

    public function update(Skill $skill, array $data): Skill
    {
        $skill->update($data);
        return $skill;
    }

    public function delete(Skill $skill): void
    {
        $skill->delete();
    }
}