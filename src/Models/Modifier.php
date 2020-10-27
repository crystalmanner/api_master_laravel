<?php
namespace FreshinUp\ActivityApi\Models;

use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Model;

class Modifier extends Model
{
    use GeneratesUuid;

    protected $table = 'activity_modifiers';
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at'];
}
