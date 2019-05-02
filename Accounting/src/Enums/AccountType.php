<?php
/**
 * Author: Xavier Au
 * Date: 2019-04-09
 * Time: 01:35
 */

namespace Anacreation\Accounting\Enums;


use MyCLabs\Enum\Enum;

/**
 * Class AccountType
 * @method static AccountType Default
 * @method static AccountType Saving
 * @method static AccountType Current
 * @package Anacreation\Accounting\Enums
 */
class AccountType extends Enum
{
    private const Default = 'default';
    private const Saving  = 'saving';
    private const Current = 'current';
}