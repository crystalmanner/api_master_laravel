<?php

namespace Tests\Feature\API;

use FreshinUp\ActivityApi\Models\Modifier;
use FreshinUp\ActivityApi\Models\SavedSearch;
use FreshinUp\ActivityApi\Tests\TestCase;
use FreshinUp\FreshBusForms\Models\User\User;
use Laravel\Passport\Passport;

class SavedSearchTest extends TestCase
{
    /**
     * @test
     */
    public function testSavedSearch()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $modifier1 = factory(Modifier::class)->create();
        $modifier2 = factory(Modifier::class)->create();

        $search = factory(SavedSearch::class)->make();

        $inputs = array_merge($search->toArray(), [
            'uuid' => $search->uuid,
            'user_uuid' => $user->uuid,
            'modifiers' => [$modifier1->uuid, $modifier2->uuid]
        ]);

        $data = $this->json('POST', route('saved-searches.store'), $inputs)
            ->assertStatus(201)
            ->assertJsonStructure(['data'])
            ->json('data');

        $this->assertDatabaseHas('activity_saved_searches', [
            'name' => $search->name,
            'uuid' => $search->uuid,
            'user_uuid' => $user->uuid,
            'filters' => json_encode($search->filters)
        ]);

        $this->assertDatabaseHas('activity_saved_searches_modifiers', [
            'id' => $modifier1->id,
            'saved_search_uuid' => $search->uuid,
            'modifier_uuid' => $modifier1->uuid,
        ]);

        $this->assertDatabaseHas('activity_modifiers', [
            'uuid' => $modifier1->uuid,
            'name' => $modifier1->name,
            'resource_name' => $modifier1->resource_name,
            'label' => $modifier1->label,
            'placeholder' => $modifier1->placeholder,
            'type' => $modifier1->type,
            'filter' => $modifier1->filter,
            'value_param' => $modifier1->value_param,
            'text_param' => $modifier1->text_param,
        ]);

        $this->assertDatabaseHas('activity_modifiers', [
            'uuid' => $modifier2->uuid,
            'name' => $modifier2->name,
            'resource_name' => $modifier2->resource_name,
            'label' => $modifier2->label,
            'placeholder' => $modifier2->placeholder,
            'type' => $modifier2->type,
            'filter' => $modifier2->filter,
            'value_param' => $modifier2->value_param,
            'text_param' => $modifier2->text_param,
        ]);
    }
}
