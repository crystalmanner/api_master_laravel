<?php

namespace Tests\Feature\API;

use FreshinUp\ActivityApi\Models\ReminderUnit;
use FreshinUp\ActivityApi\Tests\TestCase;

class ReminderUnitsTest extends TestCase
{

    public function testReminderUnitIndex()
    {
        $response = $this->json('GET', route('reminder-unities.index'));
        $data = $this->assertSuccess($response)
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
        $this->assertEquals(ReminderUnit::count(), count($data));
    }
}
