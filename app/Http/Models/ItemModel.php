<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemModel extends Model
{
    public function type()
    {
        return $this->hasOne('App\Models\TypeItemModel', 'id', 'type_id');
    }
    public function additionals()
    {
        return $this->hasMany('App\Models\AdditionalItemModel', 'item_id', 'id');
    }
    use HasFactory;
    protected $table = 'items';
    protected $primarykey = 'id';
}
