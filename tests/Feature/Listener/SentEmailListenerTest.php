<?php

namespace FreshinUp\ActivityApi\Tests\Feature\Command;

use FreshinUp\ActivityApi\Listeners\AddSentEmailActivity;
use FreshinUp\ActivityApi\Models\Activity;
use FreshinUp\ActivityApi\Tests\TestCase;

class SentEmailListenerTest extends TestCase
{
    /**
     * @test
     */
    public function testEmailTextListener()
    {
        $listener = new AddSentEmailActivity();
        $listener->handle(1, 2);

        $activity = Activity::where('customer_uuid', 1)->where('salesrep_uuid', 2)->first();
        $this->assertEquals($activity->customer_uuid, 1);
        $this->assertEquals($activity->salesrep_uuid, 2);
    }
}
