<?php

use Faker\Generator as Faker;

$factory->define(App\InvoiceItem::class, function (Faker $faker) {
    return [
        'unit_price' => rand(100, 10000),
        'quantity'   => rand(1, 100)
    ];
});
