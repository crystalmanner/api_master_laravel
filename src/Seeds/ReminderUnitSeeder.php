<?php

namespace FreshinUp\ActivityApi\Seeds;

use FreshinUp\ActivityApi\Enums\ActivityReminderUnits;
use FreshinUp\ActivityApi\Models\ReminderUnit;
use Illuminate\Database\Seeder;

class ReminderUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ActivityReminderUnits::toKeyedSelectArray();
        
        foreach ($types as $id => $name) {
            ReminderUnit::updateOrCreate(
                ['id' => $id],
                ['name' => $name]
            );
        }
    }
}
