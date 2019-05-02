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
 * @method static ProjectStatus Completed
 * @package App\Enums
 */
class ProjectStatus extends Enum
{
    private const Pending   = 'pending';
    private const Active    = 'active';
    private const Completed = 'completed';
}