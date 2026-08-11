<?php

namespace App\Policies;

use App\Models\FinalReport;
use App\Models\User;

class FinalReportPolicy
{
    public function view(User $user, FinalReport $report): bool
    {
        if (! $report->relationLoaded('internship')) {
            $report->load('internship');
        }

        return match ($user->role) {
            'admin' => true,
            'supervisor' => $report->internship?->supervisor_id === $user->id,
            'intern' => $report->intern_id === $user->id,
            default => false,
        };
    }

    public function create(User $user): bool
    {
        return $user->isIntern();
    }

    public function update(User $user, FinalReport $report): bool
    {
        return $user->isAdmin() || ($user->isIntern() && $report->intern_id === $user->id);
    }
}
