<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends Model
{
    protected $fillable = [
        'amount'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'pay_on_date'
    ];

    public function setAmountAttribute(float $amount) {
        $this->attributes['amount'] = $amount * 100;
    }

    public function getAmountAttribute(int $amount): float {
        return $amount / 100;
    }
}
