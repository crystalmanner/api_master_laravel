<?php

namespace FreshinUp\ActivityApi\Seeds;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DatabaseSeederRequired::class);
        $this->call(DatabaseSeederQuickStart::class);
    }
}
