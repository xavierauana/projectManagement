<?php
/**
 * Author: Xavier Au
 * Date: 2019-04-05
 * Time: 02:49
 */

namespace App\Traits;


use App\Discount;
use Illuminate\Database\Eloquent\Relations\Relation;

trait Discountable
{
    public function discounts(): Relation {
        return $this->morphMany(Discount::class, 'discountable');
    }

    public function addDiscount(Discount $discount): void {
        $this->discounts()->save($discount);
    }

    public function removeDiscount(Discount $discount): void {
        $this->discounts()->find($discount->id)->delete();
    }
}