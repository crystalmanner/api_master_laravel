<?php

use Faker\Generator as Faker;
use FreshinUp\ActivityApi\Models\Activity;
use FreshinUp\ActivityApi\Models\Note;
use FreshinUp\ActivityApi\Models\Status;
use FreshinUp\ActivityApi\Models\Type;
use FreshinUp\FreshBusForms\Models\User\User;
use Illuminate\Support\Str;

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

$factory->define(Note::class, function (Faker $faker) {
    if (Activity::count() == 0) {
        factory(Activity::class, 3)->create();
    }
    $created_at = $faker->dateTimeThisMonth();
    return [
        // the status_ids below exist, were created in DatabaseSeeder
        'status_name' => $faker->text(10),
        'activity_uuid' => $faker->randomElement(Activity::pluck('uuid')),
        // same for the type id
        'created_at' => $created_at,
        'updated_at' => $faker->dateTimeThisMonth($created_at),
        'text' => $faker->text(20)
    ];
});
