<?php

namespace App\Models;

use Illuminate\Foundation\Auth\user as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class LoginClientModel extends Authenticatable
{
    use HasRoles;
    use Notifiable;

    protected $table = 'login_client';
    protected $primarykey = 'id';
    protected $guard = 'client';
    protected $fillable = ['password', 'verify_error'];
}
