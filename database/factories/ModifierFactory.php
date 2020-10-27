<?php

use FreshinUp\ActivityApi\Models\Modifier;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
 */

$factory->define(Modifier::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'resource_name' => $faker->word,
        'label' => $faker->word,
        'placeholder' => $faker->word,
        'type' => $faker->randomElement(['select']),
        'filter' => $faker->randomElement([null, $faker->word]),
        'value_param' => $faker->randomElement([null, $faker->word]),
        'text_param' => $faker->randomElement([null, $faker->word])
    ];
});