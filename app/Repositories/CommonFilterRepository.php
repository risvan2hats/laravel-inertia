<?php

namespace App\Repositories;

class CommonFilterRepository
{
    /**
     * Apply a search filter across multiple fields.
     */
    public function applySearchFilter($query, $search, array $fields)
    {
        return $query->when($search, function ($query) use ($search, $fields) {
            $query->where(function ($q) use ($search, $fields) {
                foreach ($fields as $field) {
                    $q->orWhere($field, 'like', "%{$search}%");
                }
            });
        });
    }

    /**
     * Apply a direct field filter.
     */
    public function applyDirectFieldFilter($query, $field, $value)
    {
        return $query->when(
            $value !== null && $value !== '',
            fn ($query) => $query->where($field, $value)
        );
    }
}
