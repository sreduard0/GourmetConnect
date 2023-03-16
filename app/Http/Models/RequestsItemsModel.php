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
    use HasFactory;
    protected $table = 'request_items';
    protected $primarykey = 'id';
    protected $fillable = ['product_id', 'request_id', 'amount', 'value'];

}
