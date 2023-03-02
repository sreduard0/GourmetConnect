<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeItemModel extends Model
{
    use HasFactory;
    protected $table = 'type_item';
    protected $primarykey = 'id';
}
