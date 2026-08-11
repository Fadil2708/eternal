<?php

namespace App\Services;

use App\Models\Testimonial;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class TestimonialService
{
    public function getPaginatedList(string $filterStatus = ''): LengthAwarePaginator
    {
        return Testimonial::with('intern.internProfile')
            ->when($filterStatus, fn ($q) => $q->where('is_published', $filterStatus === 'published'))
            ->latest()
            ->paginate(10);
    }

    public function togglePublished(string $id): Testimonial
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update(['is_published' => ! $testimonial->is_published]);

        return $testimonial->fresh();
    }

    public function getPublished(): Collection
    {
        return Testimonial::published()
            ->with('intern.internProfile')
            ->latest()
            ->get();
    }
}
