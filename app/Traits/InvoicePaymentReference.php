<?php
/**
 * Author: Xavier Au
 * Date: 2019-04-05
 * Time: 15:46
 */

namespace App\Traits;


use App\InvoicePayment;
use Illuminate\Database\Eloquent\Relations\Relation;

trait InvoicePaymentReference
{
    public function invoicePayments(): Relation {
        return $this->morphMany(InvoicePayment::class, 'reference');
    }
}