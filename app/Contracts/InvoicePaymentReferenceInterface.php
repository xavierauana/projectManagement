<?php
/**
 * Author: Xavier Au
 * Date: 2019-04-05
 * Time: 15:43
 */

namespace App\Contracts;


use Illuminate\Database\Eloquent\Relations\Relation;

interface InvoicePaymentReferenceInterface
{
    public function invoicePayments(): Relation;
}