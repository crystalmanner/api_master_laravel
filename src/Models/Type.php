<?php

namespace FreshinUp\ActivityApi\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "activity_types";

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
