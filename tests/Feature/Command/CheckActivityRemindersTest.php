<?php

namespace FreshinUp\ActivityApi\Tests\Feature\Command;

use FreshinUp\ActivityApi\Commands\CheckActivityReminders as CheckActivityRemindersCommand;
use FreshinUp\ActivityApi\Jobs\CheckActivityReminders as CheckActivityRemindersJob;
use FreshinUp\ActivityApi\Models\Activity;
use FreshinUp\FreshBusForms\Models\User\User;
use Illuminate\Support\Facades\Queue;
use FreshinUp\ActivityApi\Tests\TestCase;
use Carbon\Carbon;

class CheckActivityRemindersTest extends TestCase
{
    protected $user;
    protected $coach;
    protected $employee;

    public function createUser()
    {
        return factory(User::class)->create([
            "email" => "john2@doe.com"
        ]);
    }

    /**
     * @test
     */
    public function testCheckActivityReminderCommand()
    {
        Queue::fake();

        $user = $this->createUser();
        $activity = factory(Activity::class)->create(['status_id' => 1]);

        $command = new CheckActivityRemindersCommand();
        $command->handle();

        Queue::assertPushed(CheckActivityRemindersCommand::class, 0);
    }

    /**
     * @test
     */
    public function testActivityReminderJob()
    {
        Queue::fake();

        $user = $this->createUser();
        $activity = factory(Activity::class)->create(['status_id' => 1]);

        $command = new CheckActivityRemindersCommand();
        $command->handle();

        Queue::assertPushed(CheckActivityRemindersJob::class, 0);
    }

    /**
     * @test
     */
    public function testActivityReminderEvent()
    {
        $user = $this->createUser();
        $activity = factory(Activity::class)->create(['status_id' => 1]);
        $activity->scheduled_at = Carbon::now()->addMinutes(16);
        $activity->activity_reminder_unity_id = 2;
        $activity->activity_reminder_quantity = 15;
        $activity->save();

        $activity = Activity::where('uuid', $activity->uuid)->first();

        $command = new CheckActivityRemindersCommand();
        $send = $command->checkIfSendReminder($activity);

        $this->assertTrue($send);
    }

    /**
     * @test
     */
    public function testActivityReminderEventNoReminderMoreAfter()
    {
        $user = $this->createUser();
        $activity = factory(Activity::class)->create(['status_id' => 1]);
        $activity->scheduled_at = Carbon::now()->addMinutes(17);
        $activity->activity_reminder_unity_id = 2;
        $activity->activity_reminder_quantity = 15;
        $activity->save();

        $activity = Activity::where('uuid', $activity->uuid)->first();

        $command = new CheckActivityRemindersCommand();
        $send = $command->checkIfSendReminder($activity);

        $this->assertFalse($send);
    }

    /**
     * @test
     */
    public function testActivityReminderEventNoReminderBefore()
    {
        $user = $this->createUser();
        $activity = factory(Activity::class)->create(['status_id' => 1]);
        $activity->scheduled_at = Carbon::now()->addMinutes(14);
        $activity->activity_reminder_unity_id = 2;
        $activity->activity_reminder_quantity = 15;
        $activity->save();

        $activity = Activity::where('uuid', $activity->uuid)->first();

        $command = new CheckActivityRemindersCommand();
        $send = $command->checkIfSendReminder($activity);

        $this->assertFalse($send);
    }
}
