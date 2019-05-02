<?php
/**
 * Author: Xavier Au
 * Date: 2019-04-05
 * Time: 02:34
 */

namespace App\Enums;


use MyCLabs\Enum\Enum;


/**
 * Class DiscountType
 * @method static \App\Enums\DiscountType Percentage
 * @method static \App\Enums\DiscountType Amount
 */
class DiscountType extends Enum
{
    private const Percentage = 'percentage';
    private const Amount     = 'amount';

}