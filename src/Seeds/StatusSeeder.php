<?php

namespace FreshinUp\ActivityApi\Seeds;

use FreshinUp\ActivityApi\Enums\ActivityStatuses;
use FreshinUp\ActivityApi\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = ActivityStatuses::toKeyedSelectArray();

        foreach ($statuses as $id => $name) {
            Status::updateOrCreate(
                ['id' => $id],
                ['name' => $name]
            );
        }
    }
}
