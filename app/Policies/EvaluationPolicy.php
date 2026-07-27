<?php

namespace App\Policies;

use App\Models\Evaluation;
use App\Models\User;

class EvaluationPolicy
{
    public function view(User $user, Evaluation $evaluation): bool
    {
        if (!$evaluation->relationLoaded('internship')) {
            $evaluation->load('internship');
        }

        return match ($user->role) {
            'admin' => true,
            'supervisor' => $evaluation->internship?->supervisor_id === $user->id,
            'intern' => $evaluation->internship?->intern_id === $user->id,
            default => false,
        };
    }

    public function create(User $user): bool
    {
        return $user->isSupervisor();
    }

    public function update(User $user, Evaluation $evaluation): bool
    {
        if (!$evaluation->relationLoaded('internship')) {
            $evaluation->load('internship');
        }

        return $user->isAdmin() || ($user->isSupervisor() && $evaluation->internship?->supervisor_id === $user->id);
    }
}