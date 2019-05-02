<?php

use Faker\Generator as Faker;

$factory->define(App\Address::class, function (Faker $faker) {
    return [
        'address_1' => $faker->address,
        'address_2' => $faker->address,
        'address_3' => $faker->address,
        'type'      => \App\Enums\AddressType::Business(),
    ];
});
