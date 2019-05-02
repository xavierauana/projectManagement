<?php
/**
 * Author: Xavier Au
 * Date: 2019-04-09
 * Time: 01:32
 */

namespace Anacreation\Accounting\Contracts;


use Illuminate\Database\Eloquent\Relations\Relation;

interface HasAccountInterface
{
    public function accounts(): Relation;
}