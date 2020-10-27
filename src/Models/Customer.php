<?php

namespace FreshinUp\ActivityApi\Models;

use FreshinUp\FreshBusForms\Models\User\User;

class Customer extends User
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';
}
