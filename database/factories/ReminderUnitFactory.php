<?php

use Faker\Generator as Faker;
use FreshinUp\ActivityApi\Models\ReminderUnit;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(ReminderUnit::class, function (Faker $faker) {
    return [
        'id' => $faker->randomNumber(5),
        'name' => $faker->name,
    ];
});
