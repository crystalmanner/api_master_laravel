<?php

namespace FreshinUp\ActivityApi\Seeds;

use Illuminate\Database\Seeder;

class DatabaseSeederRequired extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StatusSeeder::class);
        $this->call(TypeSeeder::class);
        $this->call(ReminderUnitSeeder::class);
    }
}
