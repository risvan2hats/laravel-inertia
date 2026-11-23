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
    public function __construct(private UserRepository $userRepository) {}

    /**
     * Display a listing of the users with optional search and status filters.
     */
    public function index(Request $request)
    {
        $users = $this->userRepository->getUsers($request->search, $request->status);

        return Inertia::render('Users/Index', [
            'users' => $users,
            'filters' => $request->only('search', 'status'),
        ]);
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return Inertia::render('Users/Create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        $this->userRepository->createUser($data);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', [
            'user' => $user->only('id', 'name', 'email', 'status'),
        ]);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(StoreUserRequest $request, $user)
    {
        $data = $request->validated();

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $this->userRepository->updateUser($user, $data);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
