<?php

namespace Modules\Rarv\Entities;

use Illuminate\Notifications\Notifiable;
use Modules\User\Entities\Sentinel\User as BaseUser;

class User extends BaseUser
{
    use Notifiable;
}
