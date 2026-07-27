<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    public function scopeSearch(Builder $q, string $search, array $fields): Builder
    {
        return $q->when($search, fn($q) => $q->where(function ($q) use ($search, $fields) {
            foreach ($fields as $field) {
                $q->orWhere($field, 'like', '%' . $search . '%');
            }
        }));
    }

    public function scopeSearchRelation(Builder $q, string $search, string $relation, array $fields): Builder
    {
        return $q->when($search, fn($q) => $q->whereHas($relation, fn($p) => $p->where(function ($p) use ($search, $fields) {
            foreach ($fields as $field) {
                $p->orWhere($field, 'like', '%' . $search . '%');
            }
        })));
    }

    public function scopeSort(Builder $q, string $field, string $dir, array $allowedFields, array $allowedDirs = ['asc', 'desc']): Builder
    {
        $field = in_array($field, $allowedFields) ? $field : 'created_at';
        $dir = in_array($dir, $allowedDirs) ? $dir : 'desc';
        return $q->orderBy($field, $dir);
    }
}