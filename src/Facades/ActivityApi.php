<?php

namespace FreshinUp\ActivityApi\Facades;

use Illuminate\Support\Facades\Facade;

class ActivityApi extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'activity-api';
    }
}
