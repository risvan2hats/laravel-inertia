<?php

namespace App\Repositories;

class CommonRepository
{
    /**
     * Apply sorting and pagination to a query.
     */
    public function applyPagination($query, $perPage = 10, $sortBy = 'id', $sortDirection = 'desc')
    {
        return $query
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage)
            ->withQueryString(); // Preserve query parameters in pagination links
    }
}
