<?php

namespace Tests\Feature;

use App\Client;
use App\Invoice;
use App\InvoiceItem;
use App\Product;
use App\Project;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\UserGenerator;

class ManageInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function pay_invoice() {
        $this->withoutExceptionHandling();
        $user = (new UserGenerator())
            ->addPermission('edit_invoice')
            ->generate();
        $this->actingAs($user);

        /** @var \App\Invoice $invoice */
        $invoice = factory(Invoice::class)->create([
            'billable_type' => Project::class,
            'billable_id'   => factory(Project::class)->create()->id
        ]);

        $invoice->addItems(factory(InvoiceItem::class, 3)->make([
            'product_type' => Product::class,
            'product_id'   => factory(Product::class)->create(),
        ]));

        $total = $invoice->total();

        $data = [
            'invoice_number' => $invoice->invoice_number,
            'amount'         => 500
        ];

        $uri = route('invoices.pay');

        $this->post($uri, $data)
             ->assertRedirect()
             ->assertSessionHas('message');

        $this->assertDatabaseHas('invoice_payments', [
            'amount'     => $data['amount'] * 100,
            'invoice_id' => $invoice->id
        ]);

        $this->assertEquals($total - 500, $invoice->refresh()->remaining());

    }

    /**
     * @test
     */
    public function get_create_invoice_page() {
        $this->withoutExceptionHandling();
        $user = (new UserGenerator())->addPermission('create_invoice')
                                     ->generate();

        $this->actingAs($user);

        $uri = route('invoices.create');

        $response = $this->get($uri);

        $response->assertViewIs('invoices.create')
                 ->assertViewHas('projects')
                 ->assertViewHas('clients');

    }

    /**
     * @test
     */
    public function post_create_invoice() {

        $this->withoutExceptionHandling();

        $user = (new UserGenerator())
            ->addPermission('create_invoice')
            ->generate();

        $this->actingAs($user);


        $client = factory(Client::class)->create();
        $product = factory(Product::class)->create();

        $data = [
            "billable_type"  => Client::class,
            "billable_id"    => $client->id,
            "due_date"       => Carbon::createFromFormat('Y-m-d', "2019-12-1"),
            "invoice_number" => 1212,
            "items"          => [
                [
                    "product_type" => Product::class,
                    "product_id"   => $product->id,
                    "unit_price"   => $product->price,
                    "quantity"     => 123
                ]
            ],
            'internal_note'  => "This is internal note",
            'note'           => "this is external note"
        ];

        $uri = route('invoices.store');

        $response = $this->post($uri, $data);

        $response->assertRedirect(route('invoices.index'))
                 ->assertSessionHas('message');

        $this->assertDatabaseHas('invoices', [
            'billable_type'  => $data['billable_type'],
            'billable_id'    => $data['billable_id'],
            'due_date'       => $data['due_date'],
            'invoice_number' => $data['invoice_number'],
            'internal_note'  => $data['internal_note'],
            'note'           => $data['note'],
        ]);
    }

    /**
     * @test
     */
    public function delete_invoice() {
        $this->withoutExceptionHandling();
        $user = (new UserGenerator())->addPermission('delete_invoice')
                                     ->generate();

        $this->actingAs($user);

        Carbon::setTestNow("2019-12-1 00:00");

        $client = factory(Client::class)->create();
        $invoice = factory(Invoice::class)->create([
            'billable_type' => Client::class,
            'billable_id'   => $client->id,
        ]);

        $uri = route('invoices.destroy', $invoice);

        $this->delete($uri);

        $this->assertDatabaseHas('invoices', [
            'id'         => $invoice->id,
            'deleted_at' => Carbon::now(),
        ]);
    }
}
