<?php

namespace Tests\Feature\API;

use Carbon\Carbon;
use FreshinUp\ActivityApi\Enums\ActivityStatuses;
use FreshinUp\ActivityApi\Enums\ActivityTypes;
use FreshinUp\ActivityApi\Models\Activity;
use FreshinUp\ActivityApi\Models\Note;
use FreshinUp\ActivityApi\Models\ReminderUnit;
use FreshinUp\ActivityApi\Models\Status;
use FreshinUp\ActivityApi\Models\Type;
use FreshinUp\ActivityApi\Tests\TestCase;
use FreshinUp\FreshBusForms\Models\User\User;
use Laravel\Passport\Passport;

class ActivitiesTest extends TestCase
{
    public function createUser()
    {
        return factory(User::class)->create([
            "email" => "john2@doe.com"
        ]);
    }

    public function createActivity(User $user)
    {
        $data = [
            'title' => 'Test Title',
            'has_activity_reminder' => true,
            'days' => 1,
            'status_id' => 2,
            'type_id' => 1,
            'scheduled_at' => '1/1/2020',
            'activity_reminder_unity_id' => 1,
            'activity_reminder_quantity' => 1,
            'customer_uuid' => $user->uuid,
            'salesrep_uuid' => $user->uuid,
            'deals_deal_uuid' => 'string'
        ];
        return $this->json('POST', route('activities.store'), $data)->decodeResponseJson();
    }

    public function testActivitiesPost()
    {
        $user = $this->createUser();
        $activity = $this->createActivity($user);

        $result = $this->json('POST', route('activities.store'), $activity);
        $result->assertStatus(200)
            ->json('data');

        $this->assertDatabaseHas('activity_activities', [
            'status_id' => 2,
        ]);
    }

    public function testActivitiesGet()
    {
        $initialCount = Activity::count();
        $elementStructure = [
            "uuid",
            "status" => [
                "id",
                "name"
            ],
            "scheduled_at",
            "customer" => [
                "name",
                "email",
                "mobile_phone",
                "pbs_id"
            ],
            "type" => [
                "id",
                "name"
            ],
            "salesrep" => [
                "name"
            ]
        ];
        $response = $this
            ->json('GET', route('activities.index'));
        $data = $this->assertSuccess($response)
            ->assertJsonStructure([
                'data' => [
                    $elementStructure
                ]
            ])
            ->json('data');
        $this->assertNotEmpty($data);
        $this->assertEquals($initialCount, count($data));
    }


    public function testActivitiesGetSortedByStatusId()
    {
        // records created in disorder on purpose
        // the status_ids below exist, were created in DatabaseSeeder
        Activity::truncate();
        $activity1 = factory(Activity::class)->create(['status_id' => ActivityTypes::EMAIL]);
        $activity2 = factory(Activity::class)->create(['status_id' => ActivityTypes::WALK_IN]);
        $activity0 = factory(Activity::class)->create(['status_id' => ActivityTypes::PHONE_CALL]);
        $response = $this
            ->json('GET', route('activities.index', ['sort' => 'status_id']));
        $data = $this->assertSuccess($response)
            ->assertJsonStructure([
                'data'
            ])
            ->json('data');
        $this->assertEquals($activity0->status_id, $data[0]['status']['id']);
        $this->assertEquals($activity1->status_id, $data[1]['status']['id']);
        $this->assertEquals($activity2->status_id, $data[2]['status']['id']);
    }

    public function testActivitiesGetSortedByScheduledAt()
    {
        Activity::truncate();
        // records created in disorder on purpose
        factory(Activity::class)->create([
            "scheduled_at" => now()->addMinutes(333)
        ]);
        factory(Activity::class)->create([
            "scheduled_at" => now()->addMinutes(111)
        ]);
        factory(Activity::class)->create([
            "scheduled_at" => now()->addMinutes(222)
        ]);
        $data = $this
            ->json('GET', route('activities.index', ['sort' => 'scheduled_at']))
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ])
            ->json('data');
        // compare the dates: i.e 201701 < 201812
        $this->assertTrue($data[0]['scheduled_at'] < $data[1]['scheduled_at']);
        $this->assertTrue($data[1]['scheduled_at'] < $data[2]['scheduled_at']);
    }


    public function testActivitiesGetSortedByCustomerMail()
    {
        Activity::truncate();
        factory(Activity::class)->create([
            "customer_uuid" => factory(User::class)->create([
                "email" => "john2@doe.com"
            ])->uuid
        ]);
        factory(Activity::class)->create([
            "customer_uuid" => factory(User::class)->create([
                "email" => "john0@doe.com"
            ])->uuid
        ]);
        factory(Activity::class)->create([
            "customer_uuid" => factory(User::class)->create([
                "email" => "john1@doe.com"
            ])->uuid
        ]);
        $response = $this
            ->json('GET', route('activities.index', ['sort' => 'customer_email']));
        $data = $this->assertSuccess($response)
            ->assertJsonStructure([
                'data'
            ])
            ->json('data');

        $this->assertEquals(Activity::count(), count($data));
        $this->assertEquals("john0@doe.com", $data[0]['customer']['email']);
        $this->assertEquals("john1@doe.com", $data[1]['customer']['email']);
        $this->assertEquals("john2@doe.com", $data[2]['customer']['email']);
    }


    public function testActivitiesGetSortedByTypeName()
    {
        Activity::truncate();
        // string comparion to determine order: "email" < "phone_call" < "text"
        $activity2 = factory(Activity::class)->create([
            "type_id" => ActivityTypes::TEXT
        ]);
        $activity0 = factory(Activity::class)->create([
            "type_id" => ActivityTypes::EMAIL
        ]);
        $activity1 = factory(Activity::class)->create([
            "type_id" => ActivityTypes::PHONE_CALL
        ]);
        $response = $this
            ->json('GET', route('activities.index', ['sort' => 'type_name']));
        $data = $this->assertSuccess($response)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ])
            ->json('data');
        $this->assertEquals($activity0->type_id, $data[0]['type']['id']);
        $this->assertEquals($activity1->type_id, $data[1]['type']['id']);
        $this->assertEquals($activity2->type_id, $data[2]['type']['id']);
    }


    public function testActivitiesGetSortedBySaleRepEmail()
    {
        Activity::truncate();
        factory(Activity::class)->create([
            "salesrep_uuid" => factory(User::class)->create([
                "email" => "john2@domain.com"
            ])->uuid
        ]);
        factory(Activity::class)->create([
            "salesrep_uuid" => factory(User::class)->create([
                "email" => "john0@domain.com"
            ])->uuid
        ]);
        factory(Activity::class)->create([
            "salesrep_uuid" => factory(User::class)->create([
                "email" => "john1@domain.com"
            ])->uuid
        ]);
        $response = $this
            ->json('GET', route('activities.index', ['sort' => 'salesrep_email']));
        $data = $this->assertSuccess($response)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ])
            ->json('data');
        $this->assertEquals("john0@domain.com", $data[0]['salesrep']['email']);
        $this->assertEquals("john1@domain.com", $data[1]['salesrep']['email']);
        $this->assertEquals("john2@domain.com", $data[2]['salesrep']['email']);
    }


    public function testGetListWithPagination()
    {
        Activity::truncate();
        factory(Activity::class, 11)->create();

        $response = $this->get(route('activities.index', ['page[size]' => '2]']));
        $data = $response->json('data');
        $meta = $response->json('meta');

        $this->assertCount(2, $data);
        $this->assertEquals(2, $meta['per_page']);
        $this->assertEquals(11, $meta['total']);
        $this->assertEquals(6, $meta['last_page']);
        $this->assertEquals(1, $meta['current_page']);
    }


    public function testActivityDelete()
    {
        $initialCount = Activity::count();
        $activity = factory(Activity::class)->create();

        $this->assertEquals($initialCount + 1, Activity::count());
        $response = $this->json('DELETE', route('activities.destroy', $activity));
        $response->assertStatus(204);
        $this->assertEquals($initialCount, Activity::count());
        $this->assertEquals(0, Activity::where('uuid', $activity->uuid)->count());
    }

    public function testActivityDeleteNonExisting()
    {
        $count = Activity::count();
        $response = $this->json('DELETE', route('activities.destroy', "abc123"));
        $response->assertStatus(404);
        $this->assertEquals($count, Activity::count());
    }


    public function testActivityIndexFilteredByStatusId()
    {
        Activity::truncate();
        $filters = [
            ActivityStatuses::SCHEDULED => 6,
            ActivityStatuses::IN_PROGRESS => 8,
            ActivityStatuses::COMPLETED_MADE_CONTACT => 10,
            ActivityStatuses::COMPLETED_NO_CONTACT => 13,
            ActivityStatuses::OVERDUE => 15,
        ];
        // populate and test in two different loops to fill the database before actually hitting the endpoint
        foreach ($filters as $filter => $count) {
            factory(Activity::class, $count)->create(['status_id' => $filter]);
        }
        foreach ($filters as $filter => $count) {
            $response = $this
                ->json('GET', route('activities.index', ['filter[status_id]' => $filter]));
            $data = $this->assertSuccess($response)
                ->assertJsonStructure([
                    'data'
                ])
                ->json('data');
            $this->assertCount($count, $data);
        }
    }


    public function testActivityIndexFilteredByTypeId()
    {
        Activity::truncate();
        $filters = [
            ActivityTypes::PHONE_CALL => 6,
            ActivityTypes::TEXT => 8,
            ActivityTypes::EMAIL => 10,
            ActivityTypes::WALK_IN => 13,
            ActivityTypes::APPOINTMENTS => 15,
        ];
        // populate and test in two different loops to fill the database before actually hitting the endpoint
        foreach ($filters as $filter => $count) {
            factory(Activity::class, $count)->create(['type_id' => $filter]);
        }
        foreach ($filters as $filter => $count) {
            $response = $this
                ->json('GET', route('activities.index', ['filter[type_id]' => $filter]));
            $data = $this->assertSuccess($response)
                ->assertJsonStructure([
                    'data'
                ])
                ->json('data');
            $this->assertCount($count, $data);
        }
    }


    public function testActivityIndexFilteredBySaleRepUuid()
    {
        $filters = [
            factory(User::class)->create()->uuid => 6,
            factory(User::class)->create()->uuid => 8,
            factory(User::class)->create()->uuid => 10,
            factory(User::class)->create()->uuid => 13,
        ];
        // populate and test in two different loops to fill the database before actually hitting the endpoint
        foreach ($filters as $filter => $count) {
            factory(Activity::class, $count)->create(['salesrep_uuid' => $filter]);
        }
        foreach ($filters as $filter => $count) {
            $response = $this
                ->json('GET', route('activities.index', ['filter[salesrep_uuid]' => $filter]));
            $data = $this->assertSuccess($response)
                ->assertJsonStructure([
                    'data'
                ])
                ->json('data');
            $this->assertCount($count, $data);
        }
    }


    public function testActivityIndexFilteredByCustomerUuid()
    {
        Activity::truncate();
        $filters = [
            factory(User::class)->create()->uuid => 6,
            factory(User::class)->create()->uuid => 8,
            factory(User::class)->create()->uuid => 10,
            factory(User::class)->create()->uuid => 13,
        ];
        // populate and test in two different loops to fill the database before actually hitting the endpoint
        foreach ($filters as $filter => $count) {
            factory(Activity::class, $count)->create(['customer_uuid' => $filter]);
        }
        foreach ($filters as $filter => $count) {
            $response = $this
                ->json('GET', route('activities.index', ['filter[customer_uuid]' => $filter]));
            $data = $this->assertSuccess($response)
                ->assertJsonStructure([
                    'data'
                ])
                ->json('data');
            $this->assertCount($count, $data);
        }
    }


    public function testActivityIndexFilteredByScheduledAt()
    {
        Activity::truncate();
        $filters = [
            'scheduled_at_before' => 6,
            'scheduled_at_after' => 8
        ];
        factory(Activity::class, $filters['scheduled_at_before'])->create(['scheduled_at' => now()->addMinutes(-20)]);
        factory(Activity::class, $filters['scheduled_at_after'])->create(['scheduled_at' => now()->addMinutes(10)]);
        $now = now()->format('Y-m-d H:i:s');
        foreach ($filters as $filter => $count) {
            $response = $this
                ->json('GET', route('activities.index', ["filter[{$filter}]" => $now]));
            $data = $this->assertSuccess($response)
                ->assertJsonStructure([
                    'data'
                ])
                ->json('data');
            $this->assertCount($count, $data);
        }
    }


    public function testActivityCustomer()
    {
        factory(User::class, 10)->create();
        $customer = factory(User::class)->create();
        $activity = factory(Activity::class)->create(['customer_uuid' => $customer->uuid]);
        $this->assertEquals($customer->uuid, $activity->customer->uuid);
    }


    public function testActivitySalesRep()
    {
        factory(User::class, 10)->create();
        $salesrep = factory(User::class)->create();
        $activity = factory(Activity::class)->create(['salesrep_uuid' => $salesrep->uuid]);
        $this->assertEquals($salesrep->uuid, $activity->salesrep->uuid);
    }


    public function testActivityStatus()
    {
        factory(Status::class, 10)->create();
        $status = factory(Status::class)->create();
        $activity = factory(Activity::class)->create(['status_id' => $status->id]);
        $this->assertEquals($status->id, $activity->status_id);
    }


    public function testActivityType()
    {
        factory(Type::class, 10)->create();
        $type = factory(Type::class)->create();
        $activity = factory(Activity::class)->create(['type_id' => $type->id]);
        $this->assertEquals($type->id, $activity->type_id);
        $this->assertEquals($type->id, $activity->type()->first()->id);
    }


    public function testActivityReminderUnit()
    {
        factory(ReminderUnit::class, 10)->create();
        $reminderUnit = factory(ReminderUnit::class)->create();
        $activities = factory(Activity::class, 3)->create(['activity_reminder_unity_id' => $reminderUnit->id]);
        foreach ($activities as $activity) {
            $this->assertEquals($reminderUnit->id, $activity->activity_reminder_unity_id);
            $this->assertEquals($reminderUnit->id, $activity->activityReminderUnity()->first()->id);
        }
    }


    public function testActivityNotes()
    {
        factory(Note::class, 10)->create();
        $activity = factory(Activity::class)->create();
        /** @var Note[] $notes */
        $notes = factory(Note::class, 3)->create(['activity_uuid' => $activity->uuid]);
        foreach ($notes as $note) {
            $this->assertEquals($activity->uuid, $note->activity_uuid);
            $this->assertEquals($activity->uuid, $note->activity()->first()->uuid);
        }
        foreach ($activity->notes()->get() as $note) {
            $this->assertEquals($activity->uuid, $note->activity_uuid);
        }
    }


    public function testActivityShow()
    {
        // new fields: title, has_activity_reminder, activity_reminder_quantity, notes

        $activity = factory(Activity::class)->create();
        $response = $this->json('GET', 'api/activity/v1/activities/' . $activity->uuid);
        $data = $response->json('data');
        $this->assertSuccess($response)
            ->assertJsonStructure([
                "uuid",
                "title",
                "status" => [
                    "id",
                    "name"
                ],
                "scheduled_at",
                "has_activity_reminder",
                "activity_reminder_quantity",
                "customer" => [
                    "name",
                    "email",
                    "mobile_phone",
                    "pbs_id"
                ],
                "type" => [
                    "id",
                    "name"
                ],
                "salesrep" => [
                    "name"
                ],
                "notes" => [
                    '*' => [
                        "status_name",
                        "created_at",
                        "text",
                    ]
                ],
                'created_at',
                'updated_at'
            ], $data);

        $this->assertArraySubset([
            'created_at' => $activity->created_at->toISOString(),
            'updated_at' => $activity->updated_at->toISOString()
        ], $data);

        $this->assertNotNull($data['created_at']);
        $this->assertNotNull($data['updated_at']);
    }


    public function testActivityShowOnNotExisting()
    {
        $this->json('GET', route('activities.show', 'abc123'))
            ->assertStatus(404);
    }


    public function testActivityUpdateOnNotExisting()
    {
        $this->json('PUT', route('activities.update', 'abc123'))
            ->assertStatus(404);
    }

    private function activityUpdateAsUser($user, $equalKeys = [
        "title",
        "activity_reminder_unity_id",
        "activity_reminder_quantity",
        // "days"
    ], $notEqualKeys = [
        "type_id", "scheduled_at"
    ])
    {
        $activity = factory(Activity::class)->create(['type_id' => 3]);
        $payload = [
            "title" => 'General Inquiry',
            "activity_reminder_unity_id" => 1,
            "activity_reminder_quantity" => 2,
            // line below needs clarification: there is not column days in table activity_activities
            // "days" => 2,
            "type_id" => 2,
            "scheduled_at" => '2019-01-01 13:00:33'
        ];
        $initialCount = Activity::count();
        if ($user) {
            Passport::actingAs($user);
        }
        $response = $this->json('PUT', route('activities.update', $activity), $payload);
        $data = $this->assertSuccess($response)
            ->json('data');
        $this->assertEquals($initialCount, Activity::count());

        foreach ($equalKeys as $key) {
            $this->assertEquals($payload[$key], $data[$key]);
        }
        foreach ($notEqualKeys as $key) {
            $this->assertNotEquals($payload[$key], $data[$key]);
        }
    }

    public function testActivityUpdateAsLambdaUser()
    {
        // test as a guest user
        $this->activityUpdateAsUser(null);

        // then as different level
        for ($i = 0; $i < 8; $i++) {
            $user = factory(User::class)->create(['level' => $i]);
            $this->activityUpdateAsUser($user);
        }
    }


    public function testActivityUpdateAsPlatformAdmin()
    {
        $user = factory(User::class)->create(['level' => 8]); // will change to 'level' => User::PLATFORM_ADMIN
        $this->activityUpdateAsUser($user, [
            "title",
            "activity_reminder_unity_id",
            "activity_reminder_quantity",
            // "days",
            "type_id",
            "scheduled_at"
        ], []);
    }


    public function testPostActivityNotesOnNonExistingActivity()
    {
        $payload = [
            "status_id" => 2,
            "text" => "Conference call"
        ];
        $this->json('POST', route('activities.notes', 'acb123'), $payload)
            ->assertStatus(404);
    }


    public function testPostActivityNotesOnNonExistingStatus()
    {
        $activity = factory(Activity::class)->create();
        $payload = [
            "status_id" => 9999,
            "text" => "Conference call"
        ];
        $this->json('POST', route('activities.notes', $activity), $payload)
            ->assertStatus(422);
    }


    public function testPostActivityNotesWithMissingText()
    {
        $activity = factory(Activity::class)->create();
        $payload = [
            "status_id" => 2,
        ];
        $this->json('POST', route('activities.notes', $activity), $payload)
            ->assertStatus(422);
    }


    public function testPostActivityNotesWithBothTextAndStatusId()
    {
        $this->assertEquals(30, Note::count());
        $activity = factory(Activity::class)->create();
        $payload = [
            "status_id" => 2,
            "text" => "Conference call"
        ];
        $response = $this->json('POST', route('activities.notes', $activity), $payload);
        $note = $response
            ->assertStatus(201)
            ->json('data');
        $this->assertEquals(31, Note::count());
        // refresh $activity from database
        $activity = Activity::where('uuid', $activity->uuid)->first();
        $this->assertEquals($note['activity_uuid'], $activity->uuid);
        $this->assertTrue($activity->notes()->where('uuid', $note['uuid'])->exists());
        $this->assertEquals($payload['text'], $note['text']);
        $this->assertEquals(Status::find($payload['status_id'])->name, $note['status_name']);
    }


    public function testPostActivityNotesWithTextOnly()
    {
        $this->assertEquals(30, Note::count());
        $activity = factory(Activity::class)->create();
        $payload = [
            "text" => "Conference call"
        ];
        $data = $this->json('POST', route('activities.notes', $activity), $payload)
            ->assertStatus(201)
            ->json('data');
        $this->assertEquals(31, Note::count());
        $note = Note::where('uuid', $data['uuid'])->first();
        // refresh $activity from database
        $activity = Activity::where('uuid', $activity->uuid)->first();
        $this->assertEquals($note->activity_uuid, $activity->uuid);
        $this->assertTrue($activity->notes()->where('uuid', $note->uuid)->exists());
        $this->assertEquals($payload['text'], $note->text);
    }

    public function testNotesPut()
    {
        factory(Activity::class)->create(['status_id' => 1]);
        $note = factory(Note::class)->create();

        $payload = [
            'status_name' => 'status_name',
            'text' => 'kjhfwekjh edwe dewdkjhdljk hwdjk hdwjhdqwlkjdhqwkj'
        ];
        $data = $this->json('PUT', route('activities.updateNotes', $note->activity_uuid), $payload);
        $this->assertNotExceptionResponse($data);
        $data->assertStatus(200)
            ->json('data');
        $note = Note::where('activity_uuid', $note->activity_uuid)->first();
        $this->assertEquals($payload['text'], $note->text);
        $this->assertEquals($payload['status_name'], $note->status_name);
    }

    public function testFilterDealUuidOnGetActivities()
    {
        factory(Activity::class, 5)->create();
        $deal = factory(User::class)->create();
        factory(Activity::class)->create(['deals_deal_uuid' => $deal->uuid]);
        $response = $this->json('GET', '/api/activity/v1/activities?filter[deal_uuid]=' . $deal->uuid);
        $this->assertNotExceptionResponse($response);
        $data = $response->assertStatus(200)
            ->json('data');
        $this->assertEquals($deal->uuid, $data[0]['deal_uuid']);
    }
}
