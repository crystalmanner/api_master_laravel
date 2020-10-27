<?php

namespace FreshinUp\ActivityApi\Seeds;

use Faker\Factory as Faker;
use FreshinUp\ActivityApi\Models\Activity;
use FreshinUp\ActivityApi\Models\Note;
use FreshinUp\ActivityApi\Models\ReminderUnit;
use FreshinUp\ActivityApi\Models\Status;
use FreshinUp\ActivityApi\Models\Type;
use FreshinUp\FreshBusForms\Models\User\User;
use Illuminate\Database\Seeder;

class FakeActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = Status::get();
        $types = Type::get();
        $users = User::get();

        if (empty($users->count())) {
            $users = factory(User::class, 10)->create();
        }

        $reminders = ReminderUnit::get();

        $faker = Faker::create();
        for ($i = 0; $i < 10; $i++) {
            $activity = Activity::updateOrCreate([
                'scheduled_at' => $faker->dateTimeBetween("-5 days", "5 days"),
                'status_id' => $statuses->random()->id,
                'type_id' => $types->random()->id,
                'customer_uuid' => $users->random()->uuid,
                'salesrep_uuid' => $users->random()->uuid,
                'title' => $faker->realText(40),
                'activity_reminder_quantity' => $faker->randomNumber(1),
                'activity_reminder_unity_id' => $reminders->random()->id,
            ]);

            if ($activity) {
                for ($j = 0; $j < 3; $j++) {
                    $createdAt = $faker->dateTimeThisMonth();
                    Note::updateOrCreate([
                        'status_name' => $statuses->random()->name,
                        'activity_uuid' => $activity->uuid,
                        'text' => $faker->realText(200),
                        'created_at' => $createdAt,
                        'updated_at' => $faker->dateTimeThisMonth($createdAt),
                    ]);
                }
            }
        }
    }
}
