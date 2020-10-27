<?php

namespace FreshinUp\ActivityApi\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class SaleRepEmailSort implements Sort
{
    public function __invoke(Builder $query, $descending, string $property): Builder
    {
        $direction = $descending ? 'DESC' : 'ASC';
        return $query->join('users as salesrep', 'activity_activities.salesrep_uuid', '=', 'salesrep.uuid')
            ->orderByRaw("salesrep.email {$direction}");
    }
}
