<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestAdditionalItemModal extends Model
{
    use HasFactory;
    protected $table = 'request_additional_items';
    protected $primarykeu = 'id';
    protected $fillable = ['additional_id', 'item_id', 'value'];
}
