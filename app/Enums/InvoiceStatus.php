<?php
/**
 * Author: Xavier Au
 * Date: 2019-04-07
 * Time: 18:13
 */

namespace App\Enums;


use MyCLabs\Enum\Enum;


/**
 * Class InvoiceStatus
 * @method static ProjectStatus Pending
 * @method static ProjectStatus Active
 * @method static ProjectStatus Paid
 * @package App\Enums
 */
class InvoiceStatus extends Enum
{
    private const Pending = 'pending';
    private const Active  = 'active';
    private const Paid    = 'paid';
}