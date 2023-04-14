<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryAddressModel extends Model
{
    public function command()
    {
        return $this->hasOne('App\Models\RequestsModel', 'id', 'request_id');
    }
    use HasFactory;
    protected $table = 'delivery_address';
    protected $primarykey = 'id';
}
