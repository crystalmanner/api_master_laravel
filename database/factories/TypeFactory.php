<?php

use Faker\Generator as Faker;
use FreshinUp\ActivityApi\Models\Type;

$factory->define(Type::class, function (Faker $faker) {
    return [
        'id' => $faker->randomNumber(5),
        'name' => $faker->name,
    ];
});
