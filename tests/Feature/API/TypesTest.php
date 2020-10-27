<?php

namespace Tests\Feature\API;

use FreshinUp\ActivityApi\Models\Activity;
use FreshinUp\ActivityApi\Models\Type;
use FreshinUp\ActivityApi\Tests\TestCase;

class TypesTest extends TestCase
{

    public function testTypesGet()
    {
        $response = $this->json('GET', route('types.index'));
        $data = $this->assertSuccess($response)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'name'
                    ]
                ]
            ])
            ->json('data');

        // data already exist because of real seeder
        $this->assertEquals(Type::count(), count($data));
    }

    public function testTypeActivities()
    {
        $type = factory(Type::class)->create();
        $this->assertEquals(0, $type->activities()->count());
        factory(Activity::class)->create(['type_id' => factory(Type::class)->create()->id]);
        factory(Activity::class, 10)->create(['type_id' => $type->id]);
        $this->assertEquals(10, $type->activities()->count());
    }
}
