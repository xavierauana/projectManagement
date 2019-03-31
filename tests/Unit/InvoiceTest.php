<?php

namespace Tests\Unit;

use App\Client;
use App\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function belongs_to_a_client() {
        $invoice = factory(Invoice::class)->create();
        $this->assertInstanceOf(Client::class, $invoice->client);
    }
}
