<?php

namespace FreshinUp\ActivityApi\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class CustomerEmailSort implements Sort
{
    public function __invoke(Builder $query, $descending, string $property): Builder
    {
        $direction = $descending ? 'DESC' : 'ASC';
        return $query->join('users as customers', 'activity_activities.customer_uuid', '=', 'customers.uuid')
            ->orderByRaw("customers.email {$direction}");
    }
}
