<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct(protected UserRepository $userRepository) {}

    /**
     * Display users with optional filters.
     */
    public function index(Request $request)
    {
        return Inertia::render('Users/Index', [
            'users' => $this->userRepository->getUsers(
                $request->search,
                $request->status
            ),
            'filters' => $request->only('search', 'status'),
        ]);
    }

    /**
     * Show the user creation form.
     */
    public function create()
    {
        return Inertia::render('Users/Create');
    }

    /**
     * Store a new user.
     */
    public function store(StoreUserRequest $request)
    {
        $this->userRepository->createUser($request->validated());

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Show the user edit form.
     */
    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', [
            'user' => $user->only('id', 'name', 'email', 'status'),
        ]);
    }

    /**
     * Update an existing user.
     */
    public function update(StoreUserRequest $request, User $user)
    {
        $this->userRepository->updateUser($user, $request->validated());

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Delete a user.
     */
    public function destroy(User $user)
    {
        $this->userRepository->deleteUser($user);

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
