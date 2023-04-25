<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class LoginAppModel extends Authenticatable
{
    use HasRoles;
    use Notifiable;

    protected $table = 'login_app';
    protected $primarykey = 'id';
    protected $guard = 'app';
    protected $fillable = ['password', 'verify_error'];
}
