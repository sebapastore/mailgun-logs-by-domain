<?php

namespace Tests\Feature\Users;

use App\Models\Domain;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserDomainTest extends TestCase
{
    /** @test */
    public function user_domain_index_page_is_rendering()
    {
        $this->login();

        $user = User::factory()->create();

        $this->get(route('user-domain.index', ['user' => $user->id]))->assertSuccessful();
    }

    /** @test */
    public function can_attach_domain_to_user()
    {
        $this->login();

        $user = User::factory()->create();

        $domain = Domain::factory()->create();

        $this->post(route('user-domain.store', [
            'user' => $user->id,
            'domain' => $domain->id
        ]));

        $this->assertTrue($user->domains()->where('domains.id', $domain->id)->exists());
    }

    /** @test */
    public function can_detach_domain_from_user()
    {
        $this->login();

        $user = User::factory()->create();
        $domain = Domain::factory()->create();
        $user->domains()->attach($domain->id);

        $this->delete(route('user-domain.destroy', [
            'user' => $user->id,
            'domain' => $domain->id
        ]));

        $this->assertFalse($user->domains()->where('domains.id', $domain->id)->exists());
    }

}
