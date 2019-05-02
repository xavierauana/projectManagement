<?php
/**
 * Author: Xavier Au
 * Date: 2019-04-03
 * Time: 15:52
 */

namespace App\Traits;


use App\Contracts\PayeeInterface;
use App\Invoice;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

trait Billable
{
    public function invoices(): Relation {
        return $this->morphMany(Invoice::class, 'billable');
    }

    public function createInvoice(array $params = []): Invoice {
        return $this->invoices()->create($params);
    }

    abstract public function getPayee(): PayeeInterface;

    abstract public function scopePayee(Builder $q): Builder;

    abstract public function getTitle(): string;
}