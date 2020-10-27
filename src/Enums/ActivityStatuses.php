<?php

namespace FreshinUp\ActivityApi\Enums;

use BenSampo\Enum\Enum;

final class ActivityStatuses extends Enum
{
    const SCHEDULED = 1;
    const IN_PROGRESS = 2;
    const COMPLETED_MADE_CONTACT = 3;
    const COMPLETED_NO_CONTACT = 4;
    const OVERDUE = 5;


    protected static function getFriendlyKeyName(string $key): string
    {
        return ucwords(Enum::getFriendlyKeyName($key));
    }

    public static function toKeyedSelectArray()
    {
        return json_decode(json_encode(static::toSelectArray()));
    }
}
