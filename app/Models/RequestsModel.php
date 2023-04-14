<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestsModel extends Model
{

    public function request_items()
    {
        return $this->hasOne('App\Models\RequestsItemsModel', 'request_id', 'id')->where('status', 2);
    }
    public function payment()
    {
        return $this->hasOne('App\Models\PaymentMethodsModel', 'id', 'payment_method');
    }
    public function address()
    {
        return $this->hasOne('App\Models\DeliveryAddressModel', 'request_id', 'id');
    }
    use HasFactory;
    protected $table = 'requests';
    protected $primarykey = 'id';
    protected $fillable = ['status'];

}
