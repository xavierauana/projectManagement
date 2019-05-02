<?php
/**
 * Author: Xavier Au
 * Date: 2019-04-10
 * Time: 00:04
 */

namespace App\Enums;


use MyCLabs\Enum\Enum;

/**
 * Class Gender
 * @method static Gender Male
 * @method static Gender Female
 * @package App\Enums
 */
class Gender extends Enum
{

    private const Male   = 'male';
    private const Female = 'female';
}