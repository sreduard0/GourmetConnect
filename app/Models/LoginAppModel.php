<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class LoginAppModel extends Authenticatable
{
    use HasRoles;
    protected $table = 'login_app';
    protected $primarykey = 'id';
}
