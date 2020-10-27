<?php

namespace FreshinUp\ActivityApi\Controllers\Api\v1;

use FreshinUp\ActivityApi\Models\ReminderUnit;
use FreshinUp\ActivityApi\Resources\ReminderUnityResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\QueryBuilder\QueryBuilder;

class ReminderUnitController extends Controller
{

    /**
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $reminderUnits = QueryBuilder::for(ReminderUnit::class, $request)->get();
        return ReminderUnityResource::collection($reminderUnits);
    }
}
