<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdditionalItemModel extends Model
{
    public function item()
    {
        return $this->hasOne('App\Models\ItemModel', 'id', 'item_id');
    }
    protected $table = 'additional_items';
    protected $primarykey = 'id';
    use HasFactory;
    use SoftDeletes;
}
