<?php

use App\Client;
use Faker\Generator as Faker;

$factory->define(App\Invoice::class, function (Faker $faker) {
    return [
        'client_id'      => function () {
            return factory(Client::class)->create()->id;
        },
        'invoice_number' => $faker->uuid
    ];
});
