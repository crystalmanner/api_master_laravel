<?php


namespace FreshinUp\ActivityApi\Controllers\Api\v1;

use FreshinUp\ActivityApi\Models\Status;
use FreshinUp\ActivityApi\Resources\StatusResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\QueryBuilder\QueryBuilder;

class StatusController extends Controller
{

    /**
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $statuses = QueryBuilder::for(Status::class)->get();
        return StatusResource::collection($statuses);
    }
}
