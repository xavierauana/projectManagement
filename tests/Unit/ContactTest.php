<?php

namespace Tests\Unit;

use App\Client;
use App\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function belongs_to_a_client() {
        $this->assertInstanceOf(Client::class,
            factory(Contact::class)->create()->client);
    }
}
