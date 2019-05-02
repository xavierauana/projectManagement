<?php
/**
 * Author: Xavier Au
 * Date: 2019-04-07
 * Time: 11:52
 */

namespace App\Traits;


use App\InvoiceItem;
use Illuminate\Database\Eloquent\Relations\Relation;

trait IsInvoiceItem
{
    // Relation
    public function invoiceItems(): Relation {
        return $this->morphMany(InvoiceItem::class, 'product');
    }
}