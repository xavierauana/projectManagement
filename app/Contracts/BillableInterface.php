<?php
/**
 * Author: Xavier Au
 * Date: 2019-04-03
 * Time: 15:53
 */

namespace App\Contracts;


use App\Invoice;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

interface BillableInterface
{
    public function invoices(): Relation;

    public function createInvoice(array $params = []): Invoice;

    public function getPayee(): PayeeInterface;

    public function scopePayee(Builder $q): Builder;

    public function getTitle(): string;

}