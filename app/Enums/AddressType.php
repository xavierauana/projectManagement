<?php
/**
 * Author: Xavier Au
 * Date: 2019-04-05
 * Time: 18:04
 */

namespace App\Enums;


use MyCLabs\Enum\Enum;

/**
 * Class AddressType
 * @method static AddressType Business
 * @method static AddressType Residential
 * @package App\Enums
 */
class AddressType extends Enum
{
    private const Business    = 'company';
    private const Residential = 'residential';
}