<?php

namespace FreshinUp\ActivityApi\Commands;

use Carbon\Carbon;
use FreshinUp\ActivityApi\Jobs\CheckActivityReminders as CheckActivityRemindersJob;
use FreshinUp\ActivityApi\Models\Activity;
use Illuminate\Console\Command;

class CheckActivityReminders extends Command
{
    protected $signature = 'remindernotification:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends Notification if past due date';

    public function handle()
    {
        $activities = Activity::whereDate('scheduled_at', '>=', Carbon::now())->get();

        foreach ($activities as $activity) {
            $send = $this->checkIfSendReminder($activity);

            if ($send) {
                CheckActivityRemindersJob::dispatchNow($activity);
            }
        }
    }

    public function checkIfSendReminder(Activity $activity)
    {
        $unit[0] = 60 * 60 * 24;
        $unit[1] = 60 * 60;
        $unit[2] = 60;

        if ($activity->activity_reminder_quantity) {
            $ts=strtotime($activity->scheduled_at);
            $secs = ($unit[$activity->activity_reminder_unity_id] * $activity->activity_reminder_quantity);
            $now = strtotime(Carbon::now()) + 60;
            $reminder = $ts - $secs;
            if (($now >= $reminder) && !($now >= ($reminder + 90))) {
                return true;
            }
        }

        return false;
    }
}
