<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_page_renders_users_index_component(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/users')
            ->assertInertia(fn (Assert $page) => $page->component('Users/Index'));
    }

    public function test_store_rejects_missing_required_user_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('users.store'));

        $response->assertSessionHasErrors([
            'name' => 'The name field is required.',
            'email' => 'The email field is required.',
            'status' => 'The status field is required.',
            'password' => 'The password field is required.',
        ]);
        $this->assertDatabaseCount('users', 1);
    }

    public function test_update_accepts_existing_email_without_changing_password(): void
    {
        $authenticatedUser = User::factory()->create();
        $userToUpdate = User::factory()->create();

        $response = $this->actingAs($authenticatedUser)->put(route('users.update', $userToUpdate), [
            'name' => 'Updated Name',
            'email' => $userToUpdate->email,
            'status' => 'inactive',
        ]);

        $response->assertRedirectToRoute('users.index');
        $this->assertDatabaseHas('users', [
            'id' => $userToUpdate->id,
            'name' => 'Updated Name',
            'email' => $userToUpdate->email,
            'status' => 'inactive',
        ]);
    }
}
