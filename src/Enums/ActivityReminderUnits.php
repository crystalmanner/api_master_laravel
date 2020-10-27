<?php

namespace FreshinUp\ActivityApi\Enums;

use BenSampo\Enum\Enum;

final class ActivityReminderUnits extends Enum
{
    const DAYS = 0;
    const HOURS = 1;
    const MINUTES = 2;


    protected static function getFriendlyKeyName(string $key): string
    {
        return ucwords(Enum::getFriendlyKeyName($key));
    }

    public static function toKeyedSelectArray()
    {
        return json_decode(json_encode(static::toSelectArray()));
    }
}
