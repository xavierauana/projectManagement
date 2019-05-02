<?php

namespace Tests\Unit;

use App\Discount;
use App\Enums\DiscountType;
use App\InvoiceItem;
use App\Product;
use App\Project;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\InvoiceSetting;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function has_many_payment_record() {
        $invoice = (new InvoiceSetting)->create();

        $this->assertInstanceOf(Collection::class, $invoice->payments);

    }

    /**
     * @test
     */
    public function belongs_to_a_billable() {
        $dueDate = Carbon::createFromFormat("Y/m/d", "2019/12/31");
        $project = factory(Project::class)->create();
        $invoice = $project->createInvoice([
            'due_date' => $dueDate,
        ]);
        $this->assertTrue($invoice->billable->is($project));
    }

    /**
     * @test
     */
    public function has_a_due_date() {
        $this->withExceptionHandling();
        $dueDate = Carbon::createFromFormat("Y/m/d", "2020/12/31");

        $invoice = (new InvoiceSetting)
            ->setDueDate($dueDate)
            ->create();

        $this->assertTrue($dueDate->equalTo($invoice->dueDate()));

    }

    /**
     * @test
     */
    public function has_many_invoice_items() {

        $number = 3;

        $invoice = (new InvoiceSetting)
            ->setDefaultNumberOfItems($number)
            ->create();


        $this->assertEquals($number, $invoice->invoiceItems()->count());

    }

    /**
     * @test
     */
    public function invoice_total() {

        $product = factory(Product::class)->create();

        $invoice = (new InvoiceSetting)
            ->addInvoiceItem($product, 10, 10)
            ->addInvoiceItem($product, 5, 50)
            ->create();

        $this->assertEquals(350, $invoice->total());

    }

    /**
     * @test
     */
    public function invoice_has_discount() {

        $invoice = (new InvoiceSetting)->create();
        $value = 100;
        $invoice->addDiscount(new Discount([
            'type'  => DiscountType::Amount(),
            'value' => $value
        ]));


        $this->assertEquals($invoice->invoiceItems()->reduce(function (
                $carry, InvoiceItem $item
            ) {
                return $carry += $item->total();
            }, 0) - $value, $invoice->total());

    }

    /**
     * @test
     */
    public function full_paid_invoice() {

        $invoice = (new InvoiceSetting)->create();

        $total = $invoice->total();

        $remaining = $invoice->pay($total);

        $this->assertEquals(0, $remaining);

    }

    /**
     * @test
     */
    public function partial_paid_invoice() {

        $invoice = (new InvoiceSetting)->create();

        $total = $invoice->total();

        $paidAmount = $total - 10;

        $remaining = $invoice->pay($paidAmount);

        $this->assertEquals(10, $remaining);

    }

    /**
     * @test
     */
    public function persist_payment_record() {

        $invoice = (new InvoiceSetting)->create();

        $paidAmount = $invoice->total();

        $invoice->pay($paidAmount);

        $this->assertDatabaseHas('invoice_payments', [
            'invoice_id' => $invoice->id,
            'amount'     => $paidAmount * 100
        ]);

    }
}
