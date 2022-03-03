<?php

namespace Tests\Feature\Domains;

use App\Models\Domain;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DomainTest extends TestCase
{

    /** @test */
    public function domains_index_is_rendering()
    {
        $this->login();

        $this->get(route('domains.index'))->assertSuccessful();
    }

    /** @test */
    public function domains_create_page_is_rendering()
    {
        $this->login();

        $this->get(route('domains.create'))->assertSuccessful();
    }

    /** @test */
    public function can_create_domain()
    {
        $this->login();

        $data = [
            'name' => 'domainname.com',
        ];

        $this->post(route('domains.store'), $data);

        $this->assertTrue(Domain::where('name', 'domainname.com')->exists());
    }

    /** @test */
    public function domains_edit_page_is_rendering()
    {
        $this->login();

        $domain = Domain::create([
            'name' => 'domainname.com',
        ]);

        $this->get(route('domains.edit', ['domain' => $domain->id]))->assertSuccessful();
    }

    /** @test */
    public function can_update_domain()
    {
        $this->login();

        $domain = Domain::create([
            'name' => 'domainname.com',
        ]);

        $data = [
            'name' => 'domainname.com.py',
        ];

        $this->put(route('domains.update', $domain->id), $data);

        $domain->refresh();

        $this->assertTrue($domain->name === 'domainname.com.py');
    }

}
