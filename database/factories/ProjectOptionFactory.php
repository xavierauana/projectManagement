<?php

use Faker\Generator as Faker;

$factory->define(App\ProjectOption::class, function (Faker $faker) {
    return [
        "title"=>$faker->sentence
    ];
});
