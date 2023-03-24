<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationModel extends Model
{
    use HasFactory;
    protected $table = 'notification';
    protected $primarykey = 'id';
    protected $fillable = [
        'notify',
        'type',
        'title',
        'messege',
        'size',
        'centervertical',
        'user_destination',
    ];
}
