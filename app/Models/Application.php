<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Application extends Model
{
    use Auditable, HasFactory, HasUuid;

    protected $fillable = [
        'intern_id', 'vacancy_id', 'status',
        'interview_date', 'rejection_reason', 'admin_notes',
        'applied_at',
    ];

    protected $casts = [
        'interview_date' => 'datetime',
        'applied_at' => 'datetime',
        'status' => 'string',
    ];

    public function intern(): BelongsTo
    {
        return $this->belongsTo(User::class, 'intern_id');
    }

    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(Vacancy::class);
    }

    public function internship(): HasOne
    {
        return $this->hasOne(Internship::class);
    }

    public function scopeSubmitted(Builder $query): Builder
    {
        return $query->where('status', 'submitted');
    }

    public function scopeUnderReview(Builder $query): Builder
    {
        return $query->where('status', 'under_review');
    }

    public function scopeAccepted(Builder $query): Builder
    {
        return $query->where('status', 'accepted');
    }

    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('status', 'rejected');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereIn('status', ['submitted', 'under_review', 'interview_scheduled']);
    }
}
