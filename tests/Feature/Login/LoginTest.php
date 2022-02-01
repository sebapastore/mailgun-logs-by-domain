<?php

namespace Tests\Feature\Login;

use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function login_shows_email_and_password_inputs()
    {
        $this->withoutExceptionHandling();

        $this->get('/login')->assertSuccessful();
    }
}
