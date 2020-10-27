<?php

namespace FreshinUp\ActivityApi\Seeds;

use FreshinUp\ActivityApi\Models\Modifier;
use FreshinUp\ActivityApi\Models\SavedSearch;
use FreshinUp\FreshBusForms\Models\User\User;
use FreshinUp\ActivityApi\Models\Activity;
use Illuminate\Database\Seeder;

class SavedSearchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modifierDateAfter = Modifier::where('name', 'date_after')->first();
        $modifierDateBefore = Modifier::where('name', 'date_before')->first();
        $modifierStatus = Modifier::where('name', 'status')->first();
        $modifierLeadSource = Modifier::where('name', 'source')->first();
        $modifierSalesRep = Modifier::where('name', 'salesrep')->first();
        $modifierType = Modifier::where('name', 'type')->first();
        $modifierCustomer = Modifier::where('name', 'customer')->first();
        $demoAdmin = factory(User::class)->create();

        $activities = Activity::get();
        $customers = User::get();

        $saved = [
            [
                'name' => 'My Custom Report #1',
                'filters' => json_encode([
                    'date_after' => '02-01-2020',
                    'date_before' => '02-27-2020',
                ]),
                'user_uuid' => $demoAdmin->uuid,
                'modifiers' => [$modifierDateAfter->uuid, $modifierDateBefore->uuid]
            ],
            [
                'name' => 'My Custom Report #2',
                'filters' => json_encode([
                    'customer_uuid' => $customers->random()->uuid,
                ]),
                'user_uuid' => $demoAdmin->uuid,
                'modifiers' => [$modifierCustomer->uuid, $modifierLeadSource->uuid]
            ],
            [
                'name' => 'My Custom Report #3',
                'filters' => json_encode([
                    'customer_uuid' => $customers->random()->uuid,
                ]),
                'user_uuid' => $demoAdmin->uuid,
                'modifiers' => [$modifierSalesRep->uuid, $modifierType->uuid]
            ],
            [
                'name' => 'My Custom Report #4',
                'filters' => json_encode([
                    'activity_uuid' => $activities->random()->uuid,
                    'customer_uuid' => $customers->random()->uuid,
                ]),
                'user_uuid' => $demoAdmin->uuid,
                'modifiers' => [$modifierSalesRep->uuid, $modifierStatus->uuid]
            ],
            [
                'name' => 'My Custom Report #5',
                'filters' => json_encode([
                    'activity_uuid' => $activities->random()->uuid,
                    'customer_uuid' => $customers->random()->uuid,
                ]),
                'user_uuid' => $demoAdmin->uuid,
                'modifiers' => [$modifierCustomer->uuid]
            ],
            [
                'name' => 'My Custom Report #6',
                'filters' => json_encode([
                    'activity_uuid' => $activities->random()->uuid,
                ]),
                'user_uuid' => $demoAdmin->uuid,
                'modifiers' => [$modifierStatus->uuid, $modifierLeadSource->uuid]
            ],
            [
                'name' => 'My Custom Report #7',
                'filters' => json_encode([
                    'customer_uuid' => $customers->random()->uuid,
                ]),
                'user_uuid' => $demoAdmin->uuid,
                'modifiers' => [$modifierStatus->uuid,  $modifierLeadSource->uuid]
            ],
            [
                'name' => 'My Custom Report #8',
                'filters' => json_encode([
                    'customer_uuid' => $customers->random()->uuid,
                    'activity_uuid' => $activities->random()->uuid,
                ]),
                'user_uuid' => $demoAdmin->uuid,
                'modifiers' => [$modifierSalesRep->uuid, $modifierType->uuid]
            ],
            [
                'name' => 'My Custom Report #9',
                'filters' => json_encode([
                    'activity_uuid' => $activities->random()->uuid,
                    'customer_uuid' => $customers->random()->uuid,
                ]),
                'user_uuid' => $demoAdmin->uuid,
                'modifiers' => [$modifierSalesRep->uuid, $modifierStatus->uuid]
            ],
            [
                'name' => 'My Custom Report #10',
                'filters' => json_encode([
                    'activity_uuid' => $activities->random()->uuid,
                    'customer_uuid' => $customers->random()->uuid,
                ]),
                'user_uuid' => $demoAdmin->uuid,
                'modifiers' => [$modifierCustomer->uuid]
            ]
        ];

        foreach ($saved as $item) {
            $savedSearch = SavedSearch::firstOrCreate([
                'name' => $item['name'],
            ], $item);
            $savedSearch->update($item);
        }
    }
}
