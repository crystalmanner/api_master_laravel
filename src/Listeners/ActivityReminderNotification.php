<?php

namespace FreshinUp\ActivityApi\Listeners;

use FreshinUp\FreshBusForms\Mail\SendGridTemplate;
use FreshinUp\FreshBusForms\Models\User\User;
use Illuminate\Support\Facades\Mail;

class ActivityReminderNotification
{
    /**
     * Handle the event.
     *
     * @param $activity
     */
    public function handle($activity)
    {
        $user = User::where('uuid', $activity->salesrep_uuid)->first();
        Mail::to($user->email)->queue(new SendGridTemplate(mailtpl('activity-reminder'), [
            'to' => [
                'name' => $user->name,
            ],
        ]));
    }
}
