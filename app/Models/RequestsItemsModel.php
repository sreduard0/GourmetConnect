<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestsItemsModel extends Model
{
    public function product()
    {
        return $this->hasOne('App\Models\ItemModel', 'id', 'product_id');
    }
    public function additionals()
    {
        return $this->hasMany('App\Models\RequestAdditionalItemModal', 'item_id', 'id');
    }
    use HasFactory;
    protected $table = 'request_items';
    protected $primarykey = 'id';
    protected $fillable = ['request_id', 'product_id', 'amount', 'value'];

}
