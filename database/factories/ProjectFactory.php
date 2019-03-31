<?php

use Faker\Generator as Faker;

$factory->define(App\Project::class, function (Faker $faker) {
    $start_date = "2019/1/1";
    $end_date = "2019/2/1";

    return [
        'title'      => $faker->sentence,
        'start_date' => $start_date,
        'end_date'   => $end_date,
    ];
});
