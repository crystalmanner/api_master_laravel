<?php

namespace Tests\Feature\API;

use FreshinUp\ActivityApi\Enums\ActivityStatuses;
use FreshinUp\ActivityApi\Models\Activity;
use FreshinUp\ActivityApi\Models\Note;
use FreshinUp\ActivityApi\Models\Status;
use FreshinUp\ActivityApi\Tests\TestCase;

class StatusesTest extends TestCase
{

    public function testStatusesGet()
    {
        $data = $this
            ->json('GET', route('statuses.index'))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'name'
                    ]
                ]
            ])
            ->json('data');

        // data already exist because of real seeder
        $this->assertEquals(Status::count(), count($data));
    }

    public function testStatusActivities()
    {
        $status = factory(Status::class)->create();
        $this->assertEquals(0, $status->activities()->count());
        factory(Activity::class)->create(['status_id' => factory(Status::class)->create()->id]);
        factory(Activity::class, 10)->create(['status_id' => $status->id]);
        $this->assertEquals(10, $status->activities()->count());
    }
}
