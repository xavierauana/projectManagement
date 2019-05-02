<?php
/**
 * Author: Xavier Au
 * Date: 2019-04-05
 * Time: 02:11
 */

namespace Tests;


use App\Contracts\BillableInterface;
use App\Invoice;
use App\InvoiceItem;
use App\Product;
use App\Project;
use Carbon\Carbon;

class InvoiceSetting
{
    private $dueDate;
    private $billable;
    private $items = [];
    private $defaultNumberOfItems = 4;

    public function create(): Invoice {

        $dueDate = $this->dueDate ?? Carbon::createFromFormat("Y/m/d",
                "2019/12/31");
        $billable = $this->billable ?? factory(Project::class)->create();

        /** @var \App\Invoice $invoice */
        $invoice = $billable->createInvoice([
            'due_date' => $dueDate,
        ]);

        if (count($this->items) === 0) {
            for ($i = 0; $i < $this->defaultNumberOfItems; $i++) {
                $product = factory(Product::class)->create();
                $qty = rand(1, 10);
                $unitPrice = rand(1, 1000) / 100;
                //                $invoiceItem = new InvoiceItemObject($product, $unitPrice,
                //                    $qty);
                $invoiceItem = new InvoiceItem([
                    'product'    => $product,
                    'unit_price' => $unitPrice,
                    'quantity'   => $qty,
                ]);
                $invoice->addItem($invoiceItem);
            }
        } else {
            foreach ($this->items as $item) {
                $invoice->addItem($item);
            }
        }

        return $invoice;
    }

    /**
     * @param Carbon $dueDate
     * @return InvoiceSetting
     */
    public function setDueDate(Carbon $dueDate) {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * @param BillableInterface $billable
     * @return InvoiceSetting
     */
    public function setBillable(BillableInterface $billable) {
        $this->billable = $billable;

        return $this;
    }

    public function addInvoiceItem(Product $product, float $unitPrice, int $qty
    ): InvoiceSetting {
        $this->items[] = new InvoiceItem([
            'product'    => $product,
            'unit_price' => $unitPrice,
            'quantity'   => $qty,
        ]);

        return $this;
    }

    /**
     * @param int $defaultNumberOfItems
     * @return InvoiceSetting
     */
    public function setDefaultNumberOfItems(int $defaultNumberOfItems
    ): InvoiceSetting {
        $this->defaultNumberOfItems = $defaultNumberOfItems;

        return $this;
    }
}