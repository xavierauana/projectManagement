<?php

namespace Tests\Unit;

use App\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function has_many_contacts() {

        $client = factory(Client::class)->create();
        $collection = $client->contacts;

        $this->assertInstanceOf(Collection::class, $collection);

    }
}
