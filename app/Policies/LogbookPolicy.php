<?php

namespace App\Policies;

use App\Models\Logbook;
use App\Models\User;

class LogbookPolicy
{
    public function view(User $user, Logbook $logbook): bool
    {
        if (!$logbook->relationLoaded('internship')) {
            $logbook->load('internship');
        }

        return match ($user->role) {
            'admin' => true,
            'supervisor' => $logbook->internship?->supervisor_id === $user->id,
            'intern' => $logbook->intern_id === $user->id,
            default => false,
        };
    }

    public function create(User $user): bool
    {
        return $user->isIntern();
    }

    public function update(User $user, Logbook $logbook): bool
    {
        if (!$logbook->relationLoaded('internship')) {
            $logbook->load('internship');
        }

        return match ($user->role) {
            'admin' => true,
            'supervisor' => $logbook->internship?->supervisor_id === $user->id,
            'intern' => $logbook->intern_id === $user->id && $logbook->validation_status === 'draft',
            default => false,
        };
    }

    public function delete(User $user, Logbook $logbook): bool
    {
        return $user->isAdmin() || ($user->isIntern() && $logbook->intern_id === $user->id);
    }
}