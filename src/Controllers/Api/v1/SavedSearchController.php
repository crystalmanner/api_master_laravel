<?php

namespace FreshinUp\ActivityApi\Controllers\Api\v1;

use FreshinUp\ActivityApi\Models\SavedSearch as SavedSearchModel;
use FreshinUp\ActivityApi\Resources\SavedSearchResource;
use Illuminate\Http\Request;

class SavedSearchController
{
    /**
     * @param Request $request
     * @return SavedSearchResource
     */
    public function store(Request $request)
    {
        $savedSearch = SavedSearchModel::create([
            'uuid' => $request->input('uuid'),
            'name' => $request->input('name'),
            'filters' => $request->input('filters'),
            'user_uuid' => $request->input('user_uuid')
        ]);

        $savedSearch->modifiers()->sync($request->input('modifiers'));
        $savedSearch->save();

        return new SavedSearchResource($savedSearch);
    }
}
