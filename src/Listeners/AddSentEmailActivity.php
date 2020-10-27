<?php

namespace FreshinUp\ActivityApi\Listeners;

use FreshinUp\ActivityApi\Models\Activity;

class AddSentEmailActivity
{
    /**
     * Handle the event.
     *
     * @param $customer_uuid
     * @param $salesrep_uuid
     */
    public function handle($customer_uuid, $salesrep_uuid)
    {
        $activity = factory(Activity::class)->create([
            'status_id' => 1,
            'type_id' => 1,
            'customer_uuid' => $customer_uuid,
            'salesrep_uuid' => $salesrep_uuid
        ]);
    }
}
