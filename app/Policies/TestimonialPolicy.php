<?php

namespace App\Policies;

use App\Models\Testimonial;
use App\Models\User;

class TestimonialPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Testimonial $testimonial): bool
    {
        return $user->isAdmin() || $testimonial->intern_id === $user->id || $testimonial->is_published;
    }

    public function create(User $user): bool
    {
        return $user->isIntern();
    }

    public function update(User $user, Testimonial $testimonial): bool
    {
        return $user->isAdmin() || ($user->isIntern() && $testimonial->intern_id === $user->id);
    }

    public function delete(User $user, Testimonial $testimonial): bool
    {
        return $user->isAdmin();
    }

    public function publish(User $user): bool
    {
        return $user->isAdmin();
    }
}
