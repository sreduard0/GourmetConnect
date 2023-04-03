<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethodsModel extends Model
{
    use HasFactory;
    protected $table = 'payment_methods';
    protected $primarykey = 'id';
}
