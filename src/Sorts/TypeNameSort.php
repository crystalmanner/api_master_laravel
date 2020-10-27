<?php

namespace FreshinUp\ActivityApi\Sorts;

use FreshinUp\ActivityApi\Models\Type;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class TypeNameSort implements Sort
{
    public function __invoke(Builder $query, $descending, string $property): Builder
    {
        $tableName = (new Type)->getTable();
        $direction = $descending ? 'DESC' : 'ASC';
        return $query->join($tableName, 'activity_activities.type_id', '=', $tableName . '.id')
            ->orderByRaw($tableName . ".name {$direction}");
    }
}
