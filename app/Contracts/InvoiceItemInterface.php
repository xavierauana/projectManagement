<?php
/**
 * Author: Xavier Au
 * Date: 2019-04-07
 * Time: 11:50
 */

namespace App\Contracts;


use Illuminate\Database\Eloquent\Relations\Relation;

interface InvoiceItemInterface
{
    // Relation
    public function invoiceItems(): Relation;
}