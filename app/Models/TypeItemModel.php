<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeItemModel extends Model
{
    public function items()
    {
        return $this->hasMany('App\Models\ItemModel', 'type_id', 'id');
    }
    use HasFactory;
    protected $table = 'type_item';
    protected $primarykey = 'id';
}
