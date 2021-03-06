<?php

namespace Anacreation\Accounting\Models;

use Anacreation\Accounting\Contracts\TransactionInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Transaction extends Model implements TransactionInterface
{
    // Relation

    public function from(): Relation {
        return $this->belongsTo(Account::class, 'from_account_id');
    }

    public function to(): Relation {
        return $this->belongsTo(Account::class, 'to_account_id');
    }

    public function setAmountAttribute($value) {
        $this->attributes['amount'] = $value * 100;
    }

    public function getAmountAttribute($value) {
        return $value / 100;
    }
}
