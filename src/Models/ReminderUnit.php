<?php

namespace FreshinUp\ActivityApi\Models;

use Illuminate\Database\Eloquent\Model;

class ReminderUnit extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "activity_reminder_units";

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
