<?php

namespace Tests\Feature\Login;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function login_page_is_rendering()
    {
        $this->get('/login')->assertSuccessful();
    }

    /** @test */
    public function user_can_login()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $data = ['email' => $user->email, 'password' => 'password'];

        $response = $this->post('/login', $data);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');

    }
}
