<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * UserRepository constructor.
     */
    public function __construct(
        protected CommonFilterRepository $commonFilter,
        protected CommonRepository $commonRepository
    ) {}

    /**
     * Get users with optional search and status filters.
     */
    public function getUsers($search = null, $status = null)
    {
        $query = User::query();

        $this->commonFilter->applySearchFilter($query, $search, ['name', 'email']);
        $this->commonFilter->applyDirectFieldFilter($query, 'status', $status);

        return $this->commonRepository->applyPagination($query);
    }

    /**
     * Create a new user.
     */
    public function createUser(array $data): User
    {
        return User::create($data);
    }

    /**
     * Update an existing user.
     */
    public function updateUser(User $user, array $data): User
    {
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return $user;
    }

    /**
     * Delete an existing user.
     */
    public function deleteUser(User $user): bool
    {
        return $user->delete();
    }
}
