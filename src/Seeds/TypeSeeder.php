<?php

namespace FreshinUp\ActivityApi\Seeds;

use FreshinUp\ActivityApi\Models\Type;
use FreshinUp\ActivityApi\Enums\ActivityTypes;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ActivityTypes::toKeyedSelectArray();
  
        foreach ($types as $id => $name) {
            Type::updateOrCreate(
                ['id' => $id],
                ['name' => $name]
            );
        }
    }
}
