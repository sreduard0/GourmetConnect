<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersClientModel extends Model
{
    use HasFactory;
    protected $table = 'users_client';
    protected $primarykey = 'id';

    public function location()
    {
        return $this->hasOne('App\Models\DeliveryLocationsModel', 'id', 'location_id');
    }

}
