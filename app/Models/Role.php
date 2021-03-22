<?php

namespace App\Models;

use App\Http\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'role_id';

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
