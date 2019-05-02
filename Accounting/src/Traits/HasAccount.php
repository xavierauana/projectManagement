<?php
/**
 * Author: Xavier Au
 * Date: 2019-04-09
 * Time: 01:33
 */

namespace Anacreation\Accounting\Traits;


use Anacreation\Accounting\Models\Account;
use Illuminate\Database\Eloquent\Relations\Relation;

trait HasAccount
{
    public function accounts(): Relation {
        return $this->morphMany(Account::class, 'owner');
    }
}