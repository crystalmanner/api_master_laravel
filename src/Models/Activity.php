<?php

namespace FreshinUp\ActivityApi\Models;

use Dyrynda\Database\Support\GeneratesUuid;
use FreshinUp\FreshBusForms\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use GeneratesUuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "activity_activities";

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['scheduled_at'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['status', 'type', 'salesrep', 'customer', 'activityReminderUnity'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'uuid';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['has_activity_reminder'];

    /**
     * @return bool
     */
    public function getHasActivityReminderAttribute()
    {
        return $this->activity_reminder_quantity > 0;
    }

    public function activityReminderUnity()
    {
        return $this->belongsTo(ReminderUnit::class, 'activity_reminder_unity_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_uuid', 'uuid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function salesrep()
    {
        return $this->belongsTo(User::class, 'salesrep_uuid', 'uuid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
