<?php

use Faker\Generator as Faker;

$factory->define(App\Transaction::class, function (Faker $faker) {
    return [
        'from_account_id' => function () {
            return factory(\App\Account::class)->create();
        },
        'to_account_id'   => function () {
            return factory(\App\Account::class)->create();
        },
        'amount'          => 150
    ];
});
