<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikesModel extends Model
{
    use HasFactory;
    protected $table = 'likes';
    protected $primarykey = 'id';
}
