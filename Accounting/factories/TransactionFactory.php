<?php

use Anacreation\Accounting\Models\Account;
use Anacreation\Accounting\Models\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        'from_account_id' => function () {
            return factory(Account::class)->create([
                'owner_type' => "DummyObject",
                'owner_id'   => 1,
            ]);
        },
        'to_account_id'   => function () {
            return factory(Account::class)->create([
                'owner_type' => "DummyObject",
                'owner_id'   => 1,
            ]);
        },
        'amount'          => 150
    ];
});
