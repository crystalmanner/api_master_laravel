<?php

namespace FreshinUp\ActivityApi\Models;

use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use GeneratesUuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "activity_notes";

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ["created_at", "updated_at"];

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
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['uuid'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_uuid', 'uuid');
    }
}
