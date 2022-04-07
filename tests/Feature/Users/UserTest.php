<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function users_index_is_rendering()
    {
        $this->login();

        $this->get(route('users.index'))->assertSuccessful();
    }

    /** @test */
    public function users_create_page_is_rendering()
    {
        $this->login();

        $this->get(route('users.create'))->assertSuccessful();
    }

    /** @test */
    public function can_create_user()
    {
        $this->login();

        $data = [
            'name' => 'Jon Doe',
            'email' => 'test@email.com',
            'role' => User::ROLE_ADMIN,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post(route('users.store'), $data);

        $this->assertTrue(User::where('email', 'test@email.com')->exists());
    }

    /** @test */
    public function cant_create_user_without_proper_role()
    {
        $this->login();

        $data = [
            'name' => 'Jon Doe',
            'email' => 'test@email.com',
            'role' => 'abc',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post(route('users.store'), $data);

        $response->assertSessionHasErrors(['role']);

        $this->assertFalse(User::where('email', 'test@email.com')->exists());
    }

    /** @test */
    public function users_edit_page_is_rendering()
    {
        $this->login();

        $user = User::factory()->create();

        $this->get(route('users.edit', ['user' => $user->id]))->assertSuccessful();
    }

    /** @test */
    public function can_update_user()
    {
        $this->login();

        $user = User::factory()->create([
            'name' => 'Jon Doe',
            'email' => 'jon.doe@email.com',
            'role' => User::ROLE_ADMIN,
        ]);

        $data = [
            'name' => 'Jane Doe',
            'email' => 'jane.doe@email.com',
            'role' => User::ROLE_CUSTOMER,
        ];

        $response = $this->put(route('users.update', $user->id), $data);

        $user->refresh();

        $this->assertTrue($user->name === 'Jane Doe');
        $this->assertTrue($user->email === 'jane.doe@email.com');
        $this->assertTrue($user->role === User::ROLE_CUSTOMER);
    }

    /** @test */
    public function cant_update_user_without_proper_role()
    {
        $this->login();

        $user = User::factory()->create();

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => 'abc',
        ];

        $response = $this->put(route('users.update', $user->id), $data);

        $response->assertSessionHasErrors(['role']);

    }
}
