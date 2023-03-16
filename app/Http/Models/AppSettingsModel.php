<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSettingsModel extends Model
{
    use HasFactory;
    protected $table = 'app_settings';
    protected $primarykey = 'id';
}
