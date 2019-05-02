<?php

namespace Tests\Unit;

use App\InvoiceItem;
use App\Product;
use App\Project;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function invoice_item() {
        $project = factory(Project::class)->create();
        $invoice = $project->createInvoice(
            [
                'due_date' => Carbon::createFromFormat("Y/m/d", "2019/12/31"),
            ]
        );

        $product = factory(Product::class)->create();

        $qty = rand(1, 10);
        $unitPrice = rand(1, 1000) / 100;
        $invoiceItem = new InvoiceItem([
            'qty'        => $qty,
            'unit_price' => $unitPrice,
            'product'    => $product
        ]);

        $invoice->addItem($invoiceItem);

        $this->assertEquals(1, $product->invoiceItems->count());
        $this->assertTrue($product->invoiceItems->first()->is($invoiceItem));

    }
}
