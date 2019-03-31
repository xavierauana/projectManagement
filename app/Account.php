<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function getBalance() {
        return $this->balance;
    }

    public function setBalanceAttribute($value) {
        $this->attributes['balance'] = $value * 100;
    }

    public function getBalanceAttribute(int $value) {
        return $value / 100;
    }
}
