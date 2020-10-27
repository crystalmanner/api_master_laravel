<?php

namespace FreshinUp\ActivityApi\Seeds;

use Illuminate\Database\Seeder;

class DatabaseSeederQuickStart extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(FakeActivitySeeder::class);
    }
}
