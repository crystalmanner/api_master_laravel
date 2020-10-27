<?php

namespace FreshinUp\ActivityApi\Actions;

use FreshinUp\FreshBusForms\Actions\Action;
use FreshinUp\ActivityApi\Models\Activity;
use Illuminate\Support\Carbon;

class CreateActivity implements Action
{
    public function execute(array $data)
    {
        $activity = new Activity;
        $activity->title = $data['title'];
        $activity->has_activity_reminder = $data['has_activity_reminder'];
        $activity->days = $data['days'];
        $activity->status_id = $data['status_id'];
        $activity->type_id = $data['type_id'];
        $activity->scheduled_at = Carbon::parse($data['scheduled_at']);
        $activity->activity_reminder_unity_id = $data['activity_reminder_unity_id'];
        $activity->activity_reminder_quantity = $data['activity_reminder_quantity'];
        $activity->customer_uuid = $data['customer_uuid'];
        $activity->salesrep_uuid = $data['salesrep_uuid'];
        $activity->deals_deal_uuid = $data['deals_deal_uuid'];
        $activity->save();
        return $activity;
    }
}
