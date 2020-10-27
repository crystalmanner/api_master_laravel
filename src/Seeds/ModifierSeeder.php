<?php

namespace FreshinUp\ActivityApi\Seeds;

use FreshinUp\ActivityApi\Models\Modifier;
use Illuminate\Database\Seeder;

class ModifierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modifiers = [
            [
                'name' => 'date_after',
                'resource_name' => 'date_after',
                'label' => 'Min date',
                'placeholder' => 'Min date',
                'type' => 'date'
            ],
            [
                'name' => 'date_before',
                'resource_name' => 'date_before',
                'label' => 'Max date',
                'placeholder' => 'Max date',
                'type' => 'date'
            ],
            [
                'name' => 'status',
                'resource_name' => 'deal-statuses',
                'label' => 'Status & appts',
                'placeholder' => 'Status & appts',
                'type' => 'select',
                'filter' => 'filter[name]',
                'value_param' => 'id',
                'text_param' => 'name'
            ],
            [
                'name' => 'type',
                'resource_name' => 'deal-types',
                'label' => 'Opportunity types',
                'placeholder' => 'Opportunity types',
                'type' => 'select',
                'filter' => 'filter[name]',
                'value_param' => 'id',
                'text_param' => 'name'
            ],
            [
                'name' => 'source',
                'resource_name' => 'deals/v1/lead-sources',
                'label' => 'Lead sources',
                'placeholder' => 'Lead sources',
                'type' => 'autocomplete',
                'filter' => 'filter[name]',
                'value_param' => 'uuid',
                'text_param' => 'name'
            ],
            [
                'name' => 'salesrep',
                'resource_name' => 'users?filter[type]=1',
                'label' => 'Sales reps',
                'placeholder' => 'Sales reps',
                'type' => 'autocomplete',
                'filter' => 'filter[name]',
                'value_param' => 'uuid',
                'text_param' => 'name'
            ],
            [
                'name' => 'customer',
                'resource_name' => 'users?filter[type]=2,3',
                'label' => 'Customer name / ID',
                'placeholder' => 'Customer name / ID',
                'type' => 'autocomplete',
                'filter' => 'filter[name]',
                'value_param' => 'uuid',
                'text_param' => 'name'
            ],
        ];


        foreach ($modifiers as $item) {
            $comparationArray = [
                'name' => $item['name']
            ];
            if (array_key_exists('filter', $item)) {
                $comparationArray['filter'] = $item['filter'];
            }
            $modifier = Modifier::firstOrCreate($comparationArray, $item);
            $modifier->update($item);
        }
    }
}
