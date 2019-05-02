<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name'      => $faker->word,
        'price'     => $faker->numberBetween(0, 10000),
        'is_active' => true,
    ];
});
