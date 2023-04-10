<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryLocationsModel extends Model
{
    use HasFactory;
    protected $table = "delivery_locations";
    protected $primarykey = 'id';
}
