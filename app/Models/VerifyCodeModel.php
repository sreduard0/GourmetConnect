<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifyCodeModel extends Model
{
    use HasFactory;
    protected $table = 'verify_code';
    protected $primarykey = 'user_id';
    protected $fillable = ['code', 'user_id', 'device'];
}
