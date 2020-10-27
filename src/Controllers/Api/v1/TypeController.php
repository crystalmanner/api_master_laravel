<?php

namespace FreshinUp\ActivityApi\Controllers\Api\v1;

use FreshinUp\ActivityApi\Models\Type;
use FreshinUp\ActivityApi\Resources\TypeResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\QueryBuilder\QueryBuilder;

class TypeController extends Controller
{

    /**
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $types = QueryBuilder::for(Type::class, $request)->get();
        return TypeResource::collection($types);
    }
}
