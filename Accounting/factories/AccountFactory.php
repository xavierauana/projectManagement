<?php

use Anacreation\Accounting\Enums\AccountType;
use Anacreation\Accounting\Models\Account;
use Faker\Generator as Faker;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'balance' => 1000,
        'type'    => AccountType::Default()
    ];
});
