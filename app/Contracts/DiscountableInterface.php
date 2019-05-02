<?php
/**
 * Author: Xavier Au
 * Date: 2019-04-05
 * Time: 02:48
 */

namespace App\Contracts;


use App\Discount;
use App\ValueObject\DiscountObject;
use Illuminate\Database\Eloquent\Relations\Relation;

interface DiscountableInterface
{

    public function discounts(): Relation;

    public function addDiscount(Discount $discount): void;

    public function removeDiscount(Discount $discount): void;
}