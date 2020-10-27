<?php

use Faker\Generator as Faker;
use FreshinUp\ActivityApi\Models\Status;

$factory->define(Status::class, function (Faker $faker) {
    return [
        'id' => $faker->randomNumber(5),
        'name' => $faker->name,
    ];
});
