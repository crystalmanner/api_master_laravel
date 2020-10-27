<?php

use Faker\Generator as Faker;
use FreshinUp\ActivityApi\Models\SavedSearch;

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
$factory->define(SavedSearch::class, function (Faker $faker) {
    return [
        'uuid' => $faker->uuid,
        'name' => $faker->word,
        'filters' => json_encode([
            $faker->word => $faker->randomElement([$faker->word, $faker->randomNumber()]),
            $faker->word => $faker->randomElement([$faker->word, $faker->randomNumber()])
        ])
    ];
});