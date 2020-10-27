<?php

namespace FreshinUp\ActivityApi\Providers;

use FreshinUp\ActivityApi\Events\ActivityReminder;
use FreshinUp\ActivityApi\Listeners\ActivityReminderNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ActivityReminder::class => [
            ActivityReminderNotification::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
