<?php

namespace FreshinUp\ActivityApi\Models;

use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SavedSearch extends Model
{
    use GeneratesUuid;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'activity_saved_searches';

    protected $fillable = ['uuid', 'user_uuid', 'name', 'filters'];
    protected $casts = [
        'filters' => 'array',
    ];

    public function modifiers()
    {
        return $this->belongsToMany(
            Modifier::class,
            'activity_saved_searches_modifiers',
            'saved_search_uuid',
            'modifier_uuid',
            'uuid'
        );
    }
}
