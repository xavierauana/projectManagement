<?php

namespace Tests\Unit;

use App\Discount;
use App\Enums\DiscountType;
use App\InvoiceItem;
use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\InvoiceSetting;
use Tests\TestCase;

class InvoiceItemTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function has_total() {
        $qty = 10;
        $unitPrice = 15;

        $item = new InvoiceItem([
            'unit_price' => $unitPrice,
            'quantity'   => $qty,
        ]);

        $this->assertEquals($qty * $unitPrice, $item->total());

    }

    /**
     * @test
     */
    public function has_product() {
        $product = factory(Product::class)->create();
        $item = new InvoiceItem([
            'product' => $product,
        ]);

        $this->assertTrue($item->product->is($product));
    }

    /**
     * @test
     */
    public function invoice_item_has_discount() {
        $product = factory(Product::class)->create();

        $invoice = (new InvoiceSetting)
            ->addInvoiceItem($product, 10, 10)
            ->create();
        $item = $invoice->invoiceItems()->first();

        $item->addDiscount(new Discount([
            'type'  => DiscountType::Percentage(),
            'value' => 0.2,
        ]));

        $item->addDiscount(new Discount([
            'type'  => DiscountType::Amount(),
            'value' => 10
        ]));

        $this->assertEquals(70, $item->total());

    }
}
