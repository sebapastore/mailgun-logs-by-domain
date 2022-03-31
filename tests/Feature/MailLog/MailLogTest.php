<?php

namespace Tests\Feature\MailLog;

use App\Models\Domain;
use App\Models\User;
use Tests\TestCase;

class MailLogTest extends TestCase
{
    /** @test */
    public function mail_log_index_is_rendering()
    {
        $this->login();

        $this->get(route('mail-logs.index'))->assertSuccessful();
    }

    /** @test */
    public function customer_cant_access_log_data_if_domain_is_not_attached()
    {
        $customerUser = User::factory()->customer()->create();

        $this->login($customerUser);

        $domain = Domain::factory()->create();

        $this->get(route('mail-logs.index', ['domain_id' => $domain->id]))->assertStatus(403);
    }

    /** @test */
    public function customer_can_access_log_data_if_domain_is_attached()
    {
        $customerUser = User::factory()->customer()->create();
        $domain = Domain::factory()->create();
        $customerUser->domains()->attach($domain);

        $this->login($customerUser);

        echo "holaaaaaaaaaaa";
        if(!$customerUser->canAccessDomainData($domain->id)) {
            echo "chauuuu";
        } else {
            echo "adentro";
        }

        $this->get(route('mail-logs.index', ['domain_id' => $domain->id]))->assertSuccessful();
    }

    /** @test */
    public function admin_can_access_log_data_of_any_domain()
    {
        $this->login();

        $domain = Domain::factory()->create();

        $this->get(route('mail-logs.index', ['domain_id' => $domain->id]))->assertSuccessful();
    }

}

