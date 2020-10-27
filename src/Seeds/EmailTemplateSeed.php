<?php

namespace FreshinUp\FreshBusForms\Seeds;

use FreshinUp\FreshBusForms\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $templates = [
            [
                'key_id' => 'activity-reminder',
                'name' => 'Activity Reminder',
                'description' => 'Users will receive notifications on activity they have ' .
                'been assigned to. i.e. "Call John McCustomer in 15 minutes',
                'module' => 'activity'
            ],
            [
                'key_id' => 'activity-status-update',
                'name' => 'Activity Status Update',
                'description' => 'Users will receive a notification when the status of an ' .
                    'activity is changed or updated',
                'module' => 'activity'
            ],
            [
                'key_id' => 'new-activity',
                'name' => 'New Activity',
                'description' => 'User will receive a notification when ' .
                'they are assigned to a new activity.',
                'module' => 'activity'
            ],
        ];

        foreach ($templates as $template) {
            EmailTemplate::updateOrCreate([
                'key_id' => $template['key_id']
            ], [
                'name' => $template['name'],
                'description' => $template['description'],
                'module' => $template['module'],
            ]);
        }
    }
}
