<?php

use Faker\Generator as Faker;
use FreshinUp\ActivityApi\Models\Activity;
use FreshinUp\ActivityApi\Models\ReminderUnit;
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

$factory->define(Activity::class, function (Faker $faker) {
    return [
        'scheduled_at' => $faker->dateTimeBetween("-5 days", "5 days"),
        // the status_ids below exist, were created in DatabaseSeeder
        'status_id' => $faker->randomElement(Status::pluck('id')),
        // same for the type id
        'type_id' => $faker->randomElement(Type::pluck('id')),
        'customer_uuid' => factory(User::class)->create()->uuid,
        'salesrep_uuid' => factory(User::class)->create()->uuid,
        'deals_deal_uuid' => factory(User::class)->create()->uuid,
        'title' => $faker->realText(40),
        'activity_reminder_quantity' => $faker->randomNumber(1),
        'activity_reminder_unity_id' => $faker->randomElement(ReminderUnit::pluck('id')),
        'has_activity_reminder' => $faker->randomNumber(1),
        'days' => $faker->randomNumber(5),
    ];
});
