<?php

namespace FreshinUp\ActivityApi\Enums;

use BenSampo\Enum\Enum;

final class ActivityTypes extends Enum
{
    const PHONE_CALL = 1;
    const TEXT = 2;
    const EMAIL = 3;
    const WALK_IN = 4;
    const APPOINTMENTS = 5;

    protected static function getFriendlyKeyName(string $key): string
    {
        return ucwords(Enum::getFriendlyKeyName($key));
    }

    public static function toKeyedSelectArray()
    {
        return json_decode(json_encode(static::toSelectArray()));
    }
}
