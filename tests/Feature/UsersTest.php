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
}
