<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    public function like()
    {
        return $this->hasOne('App\Models\LikesModel', 'event_id', 'id')->where('item', 1)->where('client_id', auth()->guard('client')->id());
    }
    use HasFactory;
    use SoftDeletes;

    protected $table = 'items';
    protected $primarykey = 'id';
}
