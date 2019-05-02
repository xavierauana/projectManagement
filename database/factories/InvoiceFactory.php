<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Invoice::class, function (Faker $faker) {
    return [
        'invoice_number' => Str::random(),
        'due_date'       => \Carbon\Carbon::now(),
    ];
});
