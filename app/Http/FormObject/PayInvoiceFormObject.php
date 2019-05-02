<?php
/**
 * Author: Xavier Au
 * Date: 2019-04-09
 * Time: 01:15
 */

namespace App\Http\FormObject;


use App\Invoice;

class PayInvoiceFormObject
{
    /**
     * @var Invoice
     */
    private $invoice;
    /**
     * @var float
     */
    private $amount;

    /**
     * PayInvoiceFormObject constructor.
     * @param $invoice
     * @param $amount
     */
    public function __construct(string $invoice_number, float $amount) {
        if (!$invoice = Invoice::whereInvoiceNumber($invoice_number)->first()) {
            throw new \InvalidArgumentException("Invoice number is not valid!");
        }
        $this->invoice = $invoice;

        $this->amount = $amount;
    }

    /**
     * @return \App\Invoice
     */
    public function getInvoice(): \App\Invoice {
        return $this->invoice;
    }

    /**
     * @return float
     */
    public function getAmount(): float {
        return $this->amount;
    }

}