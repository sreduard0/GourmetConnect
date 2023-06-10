<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethodsModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'payment_methods';
    protected $primarykey = 'id';
    protected $fillable = ["name", "group_payment", "active", "logo_url"];
}
