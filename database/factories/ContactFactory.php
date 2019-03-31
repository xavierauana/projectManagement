<?php

use Faker\Generator as Faker;

$factory->define(App\Contact::class, function (Faker $faker) {
    return [
        'client_id' => function () {
            return factory(\App\Client::class)->create()->id;
        },
        'last_name' => $faker->lastName

    ];
});
