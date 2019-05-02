<?php

namespace Anacreation\Accounting\Models;

use Anacreation\Accounting\Enums\AccountType;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'account_type',
        'owner',
        'owner_type',
        'owner_id',
    ];

    public function getBalance() {
        return $this->balance;
    }

    public function setBalanceAttribute($value) {
        $this->attributes['balance'] = $value * 100;
    }

    public function getBalanceAttribute(int $value) {
        return $value / 100;
    }

    public function setTypeAttribute(AccountType $type) {
        $this->attributes['type'] = $type->getValue();
    }

    public function getTypeAttribute(string $value): AccountType {
        return new AccountType($value);
    }
}
