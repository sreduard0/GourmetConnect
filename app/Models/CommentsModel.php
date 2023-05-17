<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentsModel extends Model
{
    public function client()
    {
        return $this->hasOne('App\Models\UsersClientModel', 'login_id', 'user_id');
    }
    use HasFactory;
    protected $table = 'comments';
    protected $primarykey = 'id';
}
